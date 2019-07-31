<?php

class ProcessstepController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/main';

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
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('extview'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('view','edit','create','delete'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', ),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }






    public function actionView($id=null)
    {
$process=Process::model()->find('ext = :ext',[':ext'=>$ext]);
if(is_null($process)){echo 'no such process';die;}
$this->render('view',['process'=>$process]);


    }




    public function actionCreate($id=null)
    {
        $process=Process::model()->find('ext = :ext',[':ext'=>$id]);
if(is_null($process)){echo 'no such process';die;}

        $model = new Processstep;
        if (isset($_POST['Processstep'])) {
           $model->attributes = $_POST['Processstep'];
           $model->process_id=$process->id;
    //number link
    $model->number=Processstep::model()->getNumber($id);
    
           $model->ext = md5(uniqid(rand(), true));

//print_r($model->attributes);die;

           if ($model->save())
           $process=Process::model()->findbypk($model->process_id);
            $this->redirect('/process/view/id/'.$process->ext);


        }

        $this->render('create', array(
            'model' => $model));


    }

    public function actionUnlink($id)

    {
        $model=Projectsystem::model()->find('system_id = '.$id.' and project_id = '.Yii::App()->session['project']);
        $model->deleted=1;
        $model->save();
        $this->redirect('/project/view');


    }

    public function actionDelete($id)

    {
        $project = Project::model()->findbyPk(Yii::App()->session['project']);
        
        $model=Processstep::model()->findByPk($id);
      
        $process = Process::model()->findbyPk($model->process_id);
        if($process->project_id != Yii::App()->session['project']) die;
        $model->delete();
        $this->redirect('/process/view/id/'.$process->ext);

        
    }


    public function actionEdit($id)
    {
        $project = Project::model()->findbyPk(Yii::App()->session['project']);
        $model = Processstep::model()->findbyPk($id);

          if (isset($_POST['Processstep'])) {
            $model->attributes = $_POST['Processstep'];

            if ($model->save())
            $process = Process::model()->findbyPk($model->process_id);

            $this->redirect('/process/view/id/'.$process->ext);


        }

        $this->render('edit', array(
            'model' => $model,

        ));


    }


    public function loadModel($id)
    {
        $model=Project::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}
