<?php

class Batch extends CActiveRecord {

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'batch';
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


  public function getBatchFiles($id)
  {
    //$release = Yii::app()->session['release'];
    $sql = "SELECT `i`.*
            FROM `iface` `i`
            WHERE
            `i`.`batch`=".$id;
    $connection = Yii::app()->db;
    $command = $connection->createCommand($sql);
    $releases = $command->queryAll();
    return $releases;
  }



  public function hasUnprocessed($id)
  {
    $return=false;
    $sql = "SELECT `i`.*
            FROM `iface` `i`
            WHERE
            `i`.`batch`=".$id."

            AND (output != '' AND output IS NOT NULL)";
    $connection = Yii::app()->db;
    $command = $connection->createCommand($sql);
    $releases = $command->queryAll();
   // print_r($releases);die;
    if (empty($releases)) $return=true;

 return $return ;
  }

  public function deleteBatchFiles($id)
  {
    //$release = Yii::app()->session['release'];
    $sql = "DELETE `i`.*
            FROM `iface` `i`
            WHERE
            `i`.`batch`=".$id;
    $connection = Yii::app()->db;
    $command = $connection->createCommand($sql);
    $command->execute();
    return true;
  }

  public static function model($className = __CLASS__) {
    return parent::model($className);
  }

}
