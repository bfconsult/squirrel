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
        array('name,type', 'required'),
         array('name', 'length', 'max' => 255),
        array('type, parent_id', 'numerical', 'integerOnly'=>true),
        array('number, name, description', 'safe'),
        // The following rule is used by search().
        // @todo Please remove those attributes that should not be searched.
        array('id, type, name, parent_id, create_date, create_user, number', 'safe', 'on' => 'search'),
    );
  }


  public function relations() {

    return array(

         'configs' => array(self::HAS_MANY,
             'Config',
             'system_id'),

        'link' => array(
            self::HAS_MANY,
            'Projectsystem',
            'system_id'

        ),

        'system_owner' => array(
            self::HAS_ONE,
            'User',
            'create_user'
        ),

        'projects' => array(self::MANY_MANY, 'Project', 'projectsystem(system_id, project_id)'),

    );
  }


  public function getSystemsNameArray(){
    $user = User::model()->findbypk(Yii::App()->user->id);
    $projects = Project::model()->findAll('company_id = '.$user->company_id);

    $projectsIds=[];
    $projectsIdsList='';
      if (!empty($projects)) {
              foreach ($projects as $result){
              array_push($projectsIds, $result['id']);
              }
  
          $projectsIdsList = join(",", $projectsIds);
  
          } else {
              $projectsIdsList = '-1';
          }

    $sql="SELECT `s`.`id`,`s`.`name` FROM `system` `s` 
    join `projectsystem` `p` 
    on `p`.`system_id`=`s`.`id`
    WHERE `p`.`project_id` IN ($projectsIdsList)";

    $connection=Yii::app()->db;
    $command = $connection->createCommand($sql);
    $systems = $command->queryAll();
  
    $systemsById = [-1=>'None'];
    foreach($systems as $system){
    $systemsById[$system['id']]=$system['name'];
    }
    return $systemsById;
       
    
}
 

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
        'id' => 'ID',
       'parent_id'=>'Parent',
        'number' => 'Number records',
        'name' => 'Name',
        'create_user' => 'Creator',
        'type'=>    'Shared',

        'create_date' => 'Date',


    );
  }

public function getNextNumber() {
$result = 0;
    $max = System::model()->findAll(array('order'=>'number DESC','limit'=>'1', 'condition'=>'deleted=:x', 'params'=>array(':x'=>0)));

    if (isset($max[0]['number'])) $result = $max[0]['number'] +1;
    return $result;


}


}
