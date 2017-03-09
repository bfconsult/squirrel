<?php

class BatchController extends Controller
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
						'actions' => array('process', 'OCR', 'update', 'delete', 'fileUpload', 'download', 'upload', 'form','uploadZip'),
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




	public function actionOCR($id)
	{

		$model = $this->loadModel($id);
		//
		$ifaces = Batch::model()->getBatchFiles($id);
		foreach ($ifaces as $iface){

        Iface::model()->OCR($iface['id']);

		}

		$this -> redirect('/batch/');
	}


	public function actiondownload($id)
	{

		
		$ifaces = Batch::model()->getBatchFiles($id);
		header("Content-type: application/csv");
		header("Content-Disposition: attachment; filename=batch".$id.".csv");
		header("Pragma: no-cache");
		header("Expires: 0");


		$output = "Number,Name,Type,Level,Do,Cs,Sy,Sp,Sa,Im,Em,Re,So,Sc,Gi,Cm,Wb,To,Ac,Ai,Ie,Py,Fx,FM,Mp,Wo,CT,Lp,Ami,Leo,Tm\n";



		foreach ($ifaces as $iface){
			$output .= $iface['number'].','.$iface['name'].',';
$data=json_decode($iface['output'],true);

			$output .=  $data['Type'].','.$data['Level'].',';

foreach ($data['Scores'] as $value){
	$output .=  $value.',';
	}

foreach ($data['Scales'] as $scale){
	$output .=  $scale['Sex'].',';
	}

			$output .=  "\n";

		}
echo $output;



				die;
	}

/*
 * echo '<table><tr></tr><td>Number</td> <td>Name</td> <td>Type</td> <td>Level</td>
<td>Do</td>
<td>Cs</td>
<td>Sy</td>
<td>Sp</td>
<td>Sa</td>
<td>Im</td>
<td>Em</td>
<td>Re</td>
<td>So</td>
<td>Sc</td>
<td>Gi</td>
<td>Cm</td>
<td>Wb</td><td>To</td><td>Ac</td>
<td>Ai</td><td>Ie</td><td>Py</td><td>Fx</td><td>FM</td>
<td>Mp raw</td>
<td>Wo raw</td>
<td>CT raw</td>
<td>Lp raw</td>
<td>Ami raw</td>
<td>Leo raw</td>
<td>Tm raw</td></tr>';
	foreach ($ifaces as $iface){
			echo '<tr><td>'.$iface['number'].'</td><td>'.$iface['name'].'</td>';
$data=json_decode($iface['output'],true);
		//	echo '<pre>';
		//	print_r($data);
		//	echo '<br>';
echo '<td>'.$data['Type'].'</td><td>'.$data['Level'].'</td>';

foreach ($data['Scores'] as $value){
	echo '<td> '.$value.'</td>';
	}

foreach ($data['Scales'] as $scale){
		echo '<td>'.$scale['Raw'].'</td>';
	}

			echo '</tr>';
		}
		echo '</table>';
die;
	}
 * 
 */


	public function actionPreview($id, $release)
	{
		$this->layout = 'popup';
		$versions = Version::model()->getVersions($id, 12, 'batch_id');
		$model = $this->loadModel($versions[0]['id']);
		$types = Interfacetype::model()->getInterfaceTypes();
		$this->renderPartial('preview', array('model' => $model,
				'versions' => $versions, 'types' => $types, 'release' => $release
		));
	}





	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		//
		$ifaces = Batch::model()->getBatchFiles($id);
		if (file_exists('./uploads/'.$id.'zip'))
			unlink('./uploads/'.$id.'zip');

		foreach ($ifaces as $iface){
			// remove the file from new
//echo ' file to remove '.$iface['file'].'<br>';

if (file_exists('./uploads/new/'.$iface['file']))
unlink('./uploads/new/'.$iface['file']);
			// remove the iface records

			Batch::model()->deleteBatchFiles($id);


		}

		// mark the batch as deleted
		$model->deleted=1;
		$model->save();
$this -> redirect('/batch/');
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Batch',array('criteria'=>array(
				'condition'=>'deleted=0')));
		$this->render('index', array(
				'dataProvider' => $dataProvider,
		));
	}


	public function actionView($id)
	{
		$model=$this->loadModel($id);
		$this->render('view',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Batch::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}



	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='batch-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
