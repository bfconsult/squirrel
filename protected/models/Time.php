<?php

class Time extends CActiveRecord {

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'time';
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
        array('start,end,user_id', 'required'),
        array('user_id', 'numerical', 'integerOnly'=>true),
        array('number, name, description', 'safe'),
        // The following rule is used by search().
        // @todo Please remove those attributes that should not be searched.
        array('id, user_id, start, end, config_id', 'safe', 'on' => 'search'),
    );
  }


  public function relations() {

    return array(

        'system' => array(self::HAS_ONE,
             'System',
             'system_id'),


        'user_id' => array(
            self::HAS_ONE,
            'User',
            'user_id'
        ),

      
    );
  }

 

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
        'id' => 'ID',
       'user_id'=>'User',
        'start' => 'Number records',
        'end' => 'Name',
        'system_id' => 'System',
        'config_id' => 'Config',
        'note'=> 'Note'
        
    );
  }
public function getAllProjectTime($projectId){
              
 $sql="SELECT `s`.`id` FROM `system` `s` 
        join `projectsystem` `p` 
        on `p`.`system_id`=`s`.`id`
        WHERE `p`.`project_id`=".$projectId;
  $connection=Yii::app()->db;
  $command = $connection->createCommand($sql);
  $results = $command->queryAll();
  //print_r($results);
  $systemsIds=[];
  $systemsIdsList='';
    if (!empty($results)) {
            foreach ($results as $result){
            array_push($systemsIds, $result['id']);
            }

        $systemsIdsList = join(",", $systemsIds);

        } else {
            $systemsIdsList = '-1';
        }
    
        $times=Time::model()->findAll('system_id IN ('.$systemsIdsList.')');

        $result['config']=[];
        $result['configTotal']=[];
        $result['system']=[];
        $result['systemTotal']=[];

        foreach($times as $time){
            // index times by project and config
            $startTime = strtotime($time->start);
            $endTime = strtotime($time->end);
            $duration = ($endTime - $startTime)/(60*60);

            if(!empty($time->config_id)) {
                $result['config'][$time->config_id][$time->id]=$duration;
                $result['configTotal'][$time->config_id] = (isset($configTotalTimes[$time->config_id]))?$configTotalTimes[$time->config_id]+$duration:$duration;     
            }

            $result['system'][$time->system_id][$time->id]=$duration;
            $result['systemTotal'][$time->system_id] = (isset($configTotalTimes[$time->system_id]))?$configTotalTimes[$time->system_id]+$duration:$duration;     
            
        }

        return $result;

    }

}
