<?php

class Iface extends CActiveRecord {

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'iface';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
        array('file', 'required'),
         array('name', 'length', 'max' => 255),
        array('data,output', 'safe'),
        // The following rule is used by search().
        // @todo Please remove those attributes that should not be searched.
        array('id, name, create_date, data, output, file', 'safe', 'on' => 'search'),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
      
    );
  }

  public function OCR($id)
  {

    $model=Iface::model()->findByPk($id);

    $license_code = 'F77FF84E-1592-41D4-BC88-227979E076C8';
    $username =  	'BFCONSULT';

    $url = 'http://www.ocrwebservice.com/restservices/processDocument?gettext=true&pagerange=3';

    $filePath = './uploads/new/'.$model->file;

    $fp = fopen($filePath, 'r');
    $session = curl_init();

    curl_setopt($session, CURLOPT_URL, $url);
    curl_setopt($session, CURLOPT_USERPWD, "$username:$license_code");
    curl_setopt($session, CURLOPT_UPLOAD, true);
    curl_setopt($session, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($session, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($session, CURLOPT_TIMEOUT, 200);
    curl_setopt($session, CURLOPT_HEADER, false);
    curl_setopt($session, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($session, CURLOPT_INFILE, $fp);
    curl_setopt($session, CURLOPT_INFILESIZE, filesize($filePath));

    $result = curl_exec($session);

    $httpCode = curl_getinfo($session, CURLINFO_HTTP_CODE);
    curl_close($session);
    fclose($fp);

    $data = json_decode($result);

    $model->data=$data->OCRText[0][0];


    $url = 'http://www.ocrwebservice.com/restservices/processDocument?gettext=true&pagerange=5';

    $fp = fopen($filePath, 'r');
    $session = curl_init();

    curl_setopt($session, CURLOPT_URL, $url);
    curl_setopt($session, CURLOPT_USERPWD, "$username:$license_code");
    curl_setopt($session, CURLOPT_UPLOAD, true);
    curl_setopt($session, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($session, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($session, CURLOPT_TIMEOUT, 200);
    curl_setopt($session, CURLOPT_HEADER, false);
    curl_setopt($session, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($session, CURLOPT_INFILE, $fp);
    curl_setopt($session, CURLOPT_INFILESIZE, filesize($filePath));

    $result = curl_exec($session);

    $httpCode = curl_getinfo($session, CURLINFO_HTTP_CODE);
    curl_close($session);
    fclose($fp);

    $data = json_decode($result);

    $model->data.="~NEXT~".$data->OCRText[0][0];


    $model->save();
    Iface::model()->Process($model->getPrimaryKey());


  }

  public function Process($id)
  {

    $model=Iface::model()->findByPk($id);
    $first = explode('~NEXT~', $model->data);
    $page3 = $first[0];
    $second = explode(' ', $page3);
    $page5 = $first[1];
    $job = $second[0];
    $name = strtolower($second[1] . ' ' . $second[2]);
    $quadrant = $second[3];
    $level = $second[4];

    $allscores = explode('Raw', $page3);
    $scores = explode(' ', $allscores[1], 22);

    $model->name = ucwords($name);
    $model->number = $job;
    $output['Type'] = $quadrant;
    $output['Level'] = $level;

    $labels = array(
        1 => 'Do',
        2 => 'Cs',
        3 => 'Sy',
        4 => 'Sp',
        5 => 'Sa',
        6 => 'In',
        7 => 'Em',
        8 => 'Re',
        9 => 'So',
        10 => 'Sc',
        11 => 'Gi',
        12 => 'Cm',
        13 => 'Wb',
        14 => 'To',
        15 => 'Ac',
        16 => 'Ai',
        17 => 'Ie',
        18 => 'Py',
        19 => 'Fx',
        20 => 'FM',
    );
    for ($i = 1; $i < 21; $i++) {
      $scoreOutput[$labels[$i]] = $scores[$i];
    }
    $output['Scores'] = $scoreOutput;

    $allscales = explode('Norms', $page5);
    $allscales = explode(' CPP', $allscales[1]);
    $allscales = explode(' ', $allscales[0]);

    //print_r($allscales);
    $scaleOutput = array();

    $scaleLabels = array('Mp', 'Wo', 'CT', 'Lp', 'Ami', 'Leo', 'Tm');
    foreach ($scaleLabels as $label) {
      //		echo 'looking for '.$label;

      for ($i = 1; $i < (count($allscales) - 3); $i++) {
//echo '<br> checking '.$allscales[$i];
        if (strpos($allscales[$i], $label) !== false) {
          $scaleOutput[$label]['Raw'] = $allscales[$i + 1];
          $scaleOutput[$label]['Sex'] = $allscales[$i + 2];
          $scaleOutput[$label]['Total'] = $allscales[$i + 3];

        }

      }
    }
   //echo '<br>';
    $output['Scales'] = $scaleOutput;
    $model->output = json_encode($output);
    $model->save();


    return true;

  }



  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
        'id' => 'ID',
       
        'number' => 'Number',
        'name' => 'Name',
        'data' => 'Text',
      'output'=>'Output',
        'create_date' => 'Date',

        'file' => 'Image'
    );
  }

  /**
   * Retrieves a list of models based on the current search/filter conditions.
   *
   * Typical usecase:
   * - Initialize the model fields with values from filter form.
   * - Execute this method to get CActiveDataProvider instance which will filter
   * models according to data in model fields.
   * - Pass data provider to CGridView, CListView or any similar widget.
   *
   * @return CActiveDataProvider the data provider that can return the models
   * based on the search/filter conditions.
   */
  public function search() {
    // @todo Please modify the following code to remove attributes that should not be searched.

    $criteria = new CDbCriteria;

    $criteria->compare('id', $this->id);
    $criteria->compare('number', $this->number);
    $criteria->compare('name', $this->name, true);
    $criteria->compare('data', $this->data);

    return new CActiveDataProvider($this, array(
        'criteria' => $criteria,
    ));
  }


  public function addImage($iface, $id) {
    $release = Yii::App()->session['release'];
    $project = Yii::App()->session['project'];
    $model = Iface::model()->findByPk(Version::model()->getVersion($iface, 12));

    $this->name = $model->name;
    $this->interfacetype_id = $model->interfacetype_id;
    $this->number = $model->number;
    $this->photo_id = $id;
    $this->number = $model->number;
    $this->text = $model->text;
    $this->project_id = $project;
    $this->iface_id = $model->iface_id;
    $this->release_id = $release;
    if ($this->save()) {
      $version = Version::model()->getNextNumber($this->project_id, 12, 2, $this->primaryKey, $this->iface_id);
      return true;
    } else {
      return false;
    }
  }

  public static function model($className = __CLASS__) {
    return parent::model($className);
  }

}
