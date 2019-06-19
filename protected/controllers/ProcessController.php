<?php

class ProcessController extends Controller
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
                'actions' => array('view','edit','create','delete','run'),
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
       // echo 'ext is '.$id;
$process=Process::model()->find('ext = :ext',[':ext'=>$id]);

if(is_null($process)){echo 'no such process';die;}
$this->render('view',['process'=>$process]);


    }

    public function actionRun($id=null)
    {
       // echo 'ext is '.$id;
$process=Process::model()->find('ext = :ext',[':ext'=>$id]);

if(is_null($process)){echo 'no such process';die;}


    if (isset($_POST['ProcessRun'])) {
        // make a run

        $processrun=new Processrun;
        $processrun->project_id=$process->project_id;
        $processrun->number=Processrun::model()->getNumber($id);
        $processrun->process_id=$process->id;
        $processrun->status=$_POST['Status'];
        $processrun->ext= md5(uniqid(rand(), true));
        $processrun->save();
        $processRunId =$processrun->getPrimaryKey();


            // Processthe form input
            foreach ($_POST['note'] as $key=>$comment){
            $processresult=new Processresult;
            $processresult->processrun_id=$processRunId;
            $processresult->processstep_id=$key;
            $processresult->result=(isset($_POST['done'][$key]))?1:0;
            $processresult->user_id=Yii::App()->user->id;
            $processresult->comments=$comment;


            $processresult->save(false);

        
            }

        //create a configuration for the parent system.

        $config = new Config;
        $config->number = Config::model()->getNextNumber($process->system_id);
        $config->name = $process->name.' Run number '.$processrun->number;
        $config->description = 'Executed '.$process->name;
        $config->system_id = $process->system_id;
        $config->processrun_id = $processrun->id;
        $config->create_user = Yii::App()->user->id;
        $config->save();



    $this->redirect('/process/view/id/'.$process->ext); 

    }


$this->render('run',['process'=>$process]);


    }



    public function actionCreate()
    {
        $model = new Process;
        if (isset($_POST['Process'])) {
           $model->attributes = $_POST['Process'];
           $model->active=1;
           $model->ext = md5(uniqid(rand(), true));
           if ($model->save())
            $project = $model->getPrimaryKey();
            $this->redirect('/project/view');


        }

        $this->render('create', array(
            'model' => $model ));


    }
    


    public function actionUnlink($id)

    {
        $model=Projectsystem::model()->find('system_id = '.$id.' and project_id = '.Yii::App()->session['project']);
        $model->deleted=1;
        $model->save();
        $this->redirect('/project/view');


    }

    public function actionDelete($ext)

    {
        $model=Process::model()->find('ext = "'.$ext.'"');
        $model->active=0;
        if($model->save()) {


        $this->redirect('/project/view');
    }
echo 'oops, something went wrong';
    }
    public function actionSystemDelete($id)

    {
        $model=Projectsystem::model()->find('system_id = '.$id.' and project_id = '.Yii::App()->session['project']);
        $model->deleted=1;
        if($model->save()) {

            $system = System::model()->findbyPk($id);
            $system->deleted=1;
            $system->save();
        }
        $this->redirect('/project/view');


    }

    public function actionEdit()
    {
        $model = $this->loadModel(Yii::App()->session['project']);

          if (isset($_POST['Project'])) {
            $model->attributes = $_POST['Project'];
            $model->company_id = User::model()->myCompany();
            $model->extlink = md5(uniqid(rand(), true));
            $model->stage = 1;
            if ($model->save())
                $project = $model->getPrimaryKey();
            Yii::app()->session['project'] = $project;
            $this->redirect('/project/view');


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
