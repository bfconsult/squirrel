<?php

class IfaceController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
				'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
				array('allow',  // allow all users to perform 'index' and 'view' actions
						'actions' => array('index', 'view'),
						'users' => array('*'),
				),
				array('allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions' => array('process', 'create', 'update', 'delete', 'fileUpload', 'addimage', 'upload', 'form','uploadZip'),
						'users' => array('@'),
				),
				array('allow', // allow admin user to perform 'admin' and 'delete' actions
						'actions' => array('admin'),
						'users' => array('admin'),
				),
				array('deny',  // deny all users
						'users' => array('*'),
				),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */




	public function actionPreview($id, $release)
	{
		$this->layout = 'popup';
		$versions = Version::model()->getVersions($id, 12, 'iface_id');
		$model = $this->loadModel($versions[0]['id']);
		$types = Interfacetype::model()->getInterfaceTypes();
		$this->renderPartial('preview', array('model' => $model,
				'versions' => $versions, 'types' => $types, 'release' => $release
		));
	}


	public function actionIndex($id)
	{
		$dataProvider = new CActiveDataProvider('Iface' ,array('criteria'=>array(
				'condition'=>'batch='.$id)));
		$this->render('index', array(
				'dataProvider' => $dataProvider,'id'=>$id
		));
	}

	public  function actionUploadZip(){
try
{

	if (!isset($_GET['name']))
		throw new Exception('No name given.');
	$batch_name=$_GET['name'];

	$batch = new Batch;
	$batch->name=$batch_name;
	$batch->create_user=Yii::App()->user->id;
	$batch->save();
	$batch_id=$batch->getPrimaryKey();

	$target_dir = './uploads/';
if (!file_exists($target_dir))
{
if (mkdir($target_dir, 0755, true))
{
return false;
}
}
//print_r($_FILES); die;

$uploadName = $_FILES["fileToUpload"]["name"];
$uploadNameParts = explode(".", $uploadName);
if (!isset($uploadNameParts[1]))
	throw new Exception('no file extension on uploaded file');

$_FILES["fileToUpload"]["name"] = $batch_id  . ".zip";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

//echo $target_file;

//$content = $target_file;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);


// Check if file already exists
if (file_exists($target_file)) {
	throw new Exception('Sorry, your file already exists.');
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 4*1024*1024) {
	throw new Exception('Sorry, your file is too large.');

}

// Allow certain file formats
if ($imageFileType != "zip") {
	throw new Exception('Sorry you must upload a zip file.');

}

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	$message = "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
} else {
	throw new Exception('Sorry, there was an error uploading your file.');
}


$zipfile = basename($_FILES["fileToUpload"]["name"]);

$this->unzip($zipfile,$batch_id);


}catch
(Exception $ex) {

echo 'exception: ' . $ex->getMessage();

}

echo 'Batch Uploaded Successfully';

}

	public function unzip($file, $batch_id)
	{


// get the absolute path to $file
		$path = './uploads/new/';  //pathinfo(realpath($file), PATHINFO_DIRNAME);

		$zip = new ZipArchive;
		$res = $zip->open('./uploads/'.$file);
		if ($res === TRUE) {
			// extract it to the path we determined above
			$zip->extractTo($path);
			$zip->close();

				echo "WOOT! $file extracted to $path";
		} else {
			echo "Doh! I couldn't open $file";
		}

		$batch = Batch::model()->findByPK($batch_id);



		$files_array = scandir('./uploads/new');
		if(count($files_array)){$batch->number=count($files_array)-2;}
		$batch->save();





		foreach ($files_array as $key=>$file){
			if ($key >= 2){
				// copy the file to process
echo 'make new record';
				//insert a record into the db
				$model = new Iface;
				$model->file=$file;
				$model->batch=$batch_id;
				$model->save();


			}

		}
return true;
	}

	public function actionUpload()
	{

		$this->render('upload');
	}

	/**
	 * Manages all models.
	 */
	public function actionView($id)
	{
		$model=$this->loadModel($id);
		$this->render('view',array(
			'model'=>$model,
		));
	}



	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Iface the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Iface::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

        
         public function loadVersion($id)
	{
		$model=Iface::model()->findByPk(Version::model()->getVersion($id,12));
		if($model===null)
			throw new CHttpException(404,'The requested version does not exist.');
		return $model;
	}
	/**
	 * Performs the AJAX validation.
	 * @param Iface $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='iface-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
