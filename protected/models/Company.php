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



    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'company';
    }


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
            array('id, foreignid, name, description, owner_id, type, organisationtype', 'safe', 'on' => 'search'),
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

            'project' => array(self::HAS_MANY, 'Project', 'company_id'),
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

