<?php

/**
 * This is the model class for table "project".
 *
 * The followings are the available columns in table 'project':
 * @property integer $id
 * @property string $name
 * @property integer $company_id
 */
class Process extends CActiveRecord
{


    public static $frequencies = [-1=>'None',86400=>'Daily', 604800=>"Weekly", 2592000=>"Monthly", 7776000=>"Quarterly", 31536000=>"Yearly"];
	

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'process';
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array(
                'name, project_id',
                'required'
            ),
            array(
                'project_id, system_id, frequency',
                'numerical',
                'integerOnly' => true
            ),
            array('description', 'safe'),
         
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array(
                'id, name, description, project_id,active',
                'safe',
                'on' => 'search'
            )
        );
    }

    /**
     *
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            // 'labelRegions' => array(self::HAS_MANY, 'LabelRegion', 'label_id'),
            'project' => array(
                self::BELONGS_TO,
                'Project',
                'project_id'
            ),

            'steps' => array(
                self::HAS_MANY,
                'Processstep',
                'process_id'

            ),
            'runs' => array(
                self::HAS_MANY,
                'Processrun',
                'process_id'

            ),

        );
    }

    /**
     *
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description/Notes',
         'system_id' => 'System',
            'project_id' => 'Project',
            'active'=>'Active'
                 )
        ;
    }

   public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('project_id', $this->company_id);
        $criteria->compare('description', $this->description, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }


    public static function lastRun($id)
    {
    
        $sql="
        select max(date) as date from `processrun` `r`
        join `processresult` `p`
        on `p`.`processrun_id`=`r`.`id`
        where `r`.`process_id` = $id
       

        ";
        // group by `r`.`process_id`
       // order by `p`.`date` DESC

        $connection=Yii::app()->db;
        $command = $connection->createCommand($sql);
        $result = $command->queryAll();
        
        if (!empty($result)) {
            return $result[0]['date'];
        } ELSE {
            return 0;
        }
    
    }




}
