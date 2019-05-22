<?php

/**
 * This is the model class for table "project".
 *
 * The followings are the available columns in table 'project':
 * @property integer $id
 * @property string $name
 * @property integer $company_id
 */
class Processrun extends CActiveRecord
{


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     *
     * @return string the associated database table name
     */

public static $result = [
0=>'fail',
1=>'success',
2=>'incomplete'

];

    public function tableName()
    {
        return 'processrun';
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
                'number, project_id,process_id',
                'required'
            ),
            array(
                'project_id,process_id, number',
                'numerical',
                'integerOnly' => true
            ),
            
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array(
                'id, number, process_id, project_id,status,ext',
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

            'results' => array(
                self::HAS_MANY,
                'Processresult',
                'processrun_id'

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
            'number' => 'Number',
            'description' => 'Description/Notes',
         'process_id'=>'Process',
'ext'=>'External',
            'project_id' => 'Project',
            'status'=>'Status'
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




    public function getNumber($id=null) { 
        $process=Process::model()->find('ext = :ext',[':ext'=>$id]);
        if(is_null($process)){echo 'no such process';die;}
        
            $sql = "SELECT `c`.`number` AS number
           FROM `processrun` `c`
           WHERE `c`.`process_id`=".$process->id."
           ORDER BY `number` DESC
            LIMIT 0,1";

        


        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $releases = $command->queryAll();
        if (!isset($releases[0]['number'])) {
            $releases[0]['number'] = '1';
        } ELSE {
            $releases[0]['number'] = $releases[0]['number'] + 1;
        }

        
        return $releases[0]['number'];
    }




}
