<?php

class System extends CActiveRecord {

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'system';
  }



    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
        array('name', 'required'),
         array('name', 'length', 'max' => 255),
        array('number, name', 'safe'),
        // The following rule is used by search().
        // @todo Please remove those attributes that should not be searched.
        array('id, name, create_date, create_user, number', 'safe', 'on' => 'search'),
    );
  }


  public function relations() {

    return array(

         'configs' => array(self::HAS_MANY,
             'Config',
             'system_id'),

        'parent_project' => array(
            self::BELONGS_TO,
            'Project',
            'project_id'
        ),
        'system_owner' => array(
            self::HAS_ONE,
            'User',
            'create_user'
        ),
    );
  }

 

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
        'id' => 'ID',
       
        'number' => 'Number records',
        'name' => 'Name',
        'create_user' => 'Creator',

        'create_date' => 'Date',


    );
  }




}
