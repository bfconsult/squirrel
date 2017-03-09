<?php

/**
 * This is the model class for table "company".
 *
 * The followings are the available columns in table 'company':
 * @property integer $id
 * @property string $foreignid
 * @property string $name
 * @property string $description
 * @property integer $owner_id
 * @property integer $type
 * @property integer $organisationtype
 * @property integer $trade_id
 */
class Company extends CActiveRecord
{

    public static $companytype = array(1 => 'Developer or Analyst', 3 => 'Client or Project Manager', 4 => 'Tester');
    public static $companytypestatus = array(1 => 'This company is an analyst', 2 => 'you are a contact?', 3 => 'This company is client or project manager', 4 => 'This is a tester');
    public static $termtypes = array('Singular' => '', 'Plural' => 's', 'Prefix' => 'prefix', 'Output' => 'outputs', 'Output(Plural)' => 'outputs');
    public static $languages = array('en' => 'English', 'fr' => 'Francais', 'hi' => 'हिन्दी भाषा');

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Company the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'company';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, description, owner_id, type', 'required'),
            array('owner_id, type, organisationtype, trade_id', 'numerical', 'integerOnly' => true),
            array('foreignid, name', 'length', 'max' => 255),
            array('logo_id', 'file', 'types' => 'jpg,jpeg,gif,icon,png', 'maxSize' => 10 * 1024 * 1024, 'allowEmpty' => true),

            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, foreignid, name, description, owner_id, type, organisationtype, trade_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'owner' => array(self::BELONGS_TO, 'User', 'owner_id'),
            'trade' => array(self::BELONGS_TO, 'Trade', 'trade_id'),
            'documentType' => array(self::HAS_MANY, 'Documenttype', 'company_id'),
            'contact' => array(self::HAS_MANY, 'Contact', 'company_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'foreignid' => 'External Reference',
            'name' => 'Name',
            'description' => 'Description',
            'logo_id' => 'Logo',
            'owner_id' => 'Owner',
            'type' => 'Type',
            'organisationtype' => 'Company Type',
            'trade_id' => 'Trade',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('foreignid', $this->foreignid, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('owner_id', $this->owner_id);
        $criteria->compare('type', $this->type);
        $criteria->compare('organisationtype', $this->organisationtype);
        $criteria->compare('trade_id', $this->trade_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }


    public function Admins()
    {
        $company = User::model()->myCompany();

        $sql = "SELECT `u`.`firstname`, `u`.`id`, `u`.`lastname`, `u`.`admin`, `u`.`email`
          FROM `user` `u`
          Join `company` `c`
          on `u`.`company_id`=`c`.`id`
          WHERE
          `u`.`admin`=1
          AND
          `c`.`id`=" . $company;
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $admins = $command->queryAll();
        return $admins;
    }

    public function checkOwnershipUser($id)
    {
        //check the user belongs to the company
        $company = User::model()->myCompany();

        $sql = "SELECT `c`.`id`
          FROM `company` `c`
          Join `user` `u`
          on `u`.`company_id`=`c`.`id`
          WHERE
         `u`.`id`=" . $id;
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $usercompany = $command->queryAll();
        $result = FALSE;
        if ($usercompany[0]['id'] == $company) $result = TRUE;

        return $result;
    }

    public function getCompanyOwner($id)
    {

        $sql = "SELECT `u`.`id`,`u`.`firstname`,`u`.`lastname`,`c`.`name` as companyname
          FROM `user` `u`
          Join  `company` `c`
          on `c`.`companyowner_id`=`u`.`id`
          WHERE
         `c`.`id`=" . $id;
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $user = $command->queryAll();
        return $user;
    }


    public function userDestroy($id)
    {


        $sql = "DELETE
                FROM
                `company`
                WHERE
                `id`=" . $id;

        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $command->execute();

    }

    public function getProjects($id)
    {

        $sql = "SELECT `p`.*
          FROM `project` `p`
          WHERE
         `p`.`company_id`=" . $id;
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $user = $command->queryAll();
        return $user;
    }


    public function myCompanies()
    {
        $company = User::model()->myCompany();
        $criteria = new CDbCriteria;
        $criteria->addCondition('companyowner_id=' . $company);
        $criteria->addCondition('type=2');
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function matchExistingbyFK($fk)
    {
        $candidates = Yii::app()->db->createCommand()
            ->select('id')
            ->from('company u')
            ->where('foreignid like :external_id and companyowner_id = :mycompany',
                array(':external_id' => $fk, ':mycompany' => User::model()->myCompany()))
            ->queryRow();
        return $candidates['id'];
    }

    public function matchExistingbyName($name)
    {
        $candidates = Yii::app()->db->createCommand()
            ->select('id')
            ->from('company u')
            ->where('name like :name and companyowner_id = :mycompany',
                array(':name' => $name, ':mycompany' => User::model()->myCompany()))
            ->queryRow();
        return $candidates['id'];
    }


    public function getUpload()
    {
        $company = User::model()->myCompany();

        $sql = "Select *
        FROM `company_temp`
        WHERE
        `companyowner_id`=" . $company;
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $companies = $command->queryAll();
        return $companies;
    }


    public function savetempcompany($company, $record)
    {
        $user = Yii::app()->user->id;

        $sql = "INSERT INTO `company_temp` (
          `foreignid`,
          `name`,
          `companyowner_id`,
          `type`,
          `organisationtype`
          ) VALUES
          (
          '" . $record['foreignid'] . "',
          '" . $record['name'] . "',
          '" . $company . "',
          '2',
          '2')";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $command->execute();
    }

    public function newuploadcompany($record)
    {
        $sql = "INSERT INTO `company` (
      `foreignid`,
      `name`,
      `owner_id`,
      `companyowner_id`,
      `type`,
      `organisationtype`
      ) VALUES
      (
      '" . $record['foreignid'] . "',
      '" . $record['name'] . "',
      '" . $record['owner_id'] . "',
      '" . $record['companyowner_id'] . "',
      '2',
      '2')";

        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $command->execute();
    }

    public function dumpUpload($company)
    {
        $sql = "DELETE
          FROM `company_temp`
          WHERE
          `companyowner_id`=" . $company;
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $command->execute();
    }

    protected function beforeValidate()
    {

        if (empty($this->owner_id))
            $this->owner_id = Yii::app()->user->id;

        if (empty($this->companyowner_id))
            $this->companyowner_id = User::model()->myCompany();

        if (empty($this->modified_date))
            $this->modified_date = date('Y-m-d H:i:s');

        return parent::beforeValidate();
    }

    public function behaviors()
    {
        return array(
            'company_meta' => array(
                'class' => 'ext.yiiext.behaviors.model.eav.EEavBehavior',
                'tableName' => 'company_meta',
                'entityField' => 'company_id',
                'attributeField' => 'meta_name',
                'valueField' => 'meta_value',
                'modelTableFk' => 'company_id',
                'safeAttributes' => array(),
            )
        );
    }






    public function MetaLoad($key,$default) // key is keyname, default is an array of default values
    {
        $company=User::model()->myCompany();
        //$user = Yii::app()->user->id;


        $metaModel = Company::model()->findByPk($company);
        $meta_key = 'company_'.$metaModel->id.'_'.$key;
        $metaData = $metaModel->getEavAttributes(array($meta_key));
        // print_r($metaData); die;
        if (!empty($metaData[$meta_key])) {
            $metaJson = $metaData[$meta_key];
            // echo $metaJson; die;
            $meta = json_decode($metaJson, true);
            //print_r($meta); die;
        } ELSE {
            $this->MetaErase($key,$default);

           // $metaData = $metaModel->getEavAttributes(array($meta_key));
           // $metaJson = $metaData[$meta_key];
            $meta = $default;//json_decode($metaJson, true);
        }


        return $meta;
    }


    public function MetaSave($key,$meta) // key is keyname, default is an array of default values
    {
        $company = User::model()->myCompany();
        $companyMeta = Company::model()->findByPk($company);
        $meta_key = 'company_' . $companyMeta->id . '_' . $key;
        $companyMeta->setEavAttribute($meta_key, json_encode($meta));
        if($companyMeta->save()){
            return true;
        } ELSE {
      return false;
        }

    }

    public function MetaErase($key,$default)
    {
        $company = User::model()->myCompany();
        $companyMeta = Company::model()->findByPk($company);
        //$user = Yii::app()->user->id;
        $meta_key = 'company_' . $companyMeta->id . '_' . $key;
        $meta = array();
        foreach ($default as $key => $value) {
        $meta[$key] = $value;
         }

        $companyMeta->setEavAttribute($meta_key, json_encode($meta));
        $companyMeta->save();
        return $meta;
    }


}

