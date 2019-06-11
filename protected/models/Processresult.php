<?php

/**
 * This is the model class for table "project".
 *
 * The followings are the available columns in table 'project':
 * @property integer $id
 * @property string $name
 * @property integer $company_id
 */
class Processresult extends CActiveRecord
{
    public static $result = [
        0=>'fail',
        1=>'success',

        
        ];

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
        return 'processresult';
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
                'processrun_id, processstep_id,user_id,result',
                'required'
            ),
            array(
                'processrun_id,processstep_id,user_id,result',
                'numerical',
                'integerOnly' => true
            ),
            array('comments, date', 'safe'),
         
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array(
                'id, comments, processrun_id, processstep_id, user_id,result',
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
            'step' => array(
                self::BELONGS_TO,
                'Processstep',
                'processstep_id'
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
            'comments' => 'Description/Notes',
            'date' => 'Date',
            'user_id' => 'User',
            'processrun_id' => 'Run',
            'result'=>'Result'
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






}
