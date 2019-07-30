<?php

class ProjectController extends Controller
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
                'actions' => array('todo','set','view','edit','create','unlink','history','systemDelete','delete','getSystemOptions','report','getProcessOptions','copyProcess'),
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

//used to sort arrays in the print diagram view



    public function actionSet($id)
    {

        Yii::app()->session['project'] = $id;

        $myproject = array();
        $myfollows = array();
        $user = User::model()->findbyPK(Yii::App()->user->id);

        $projectlist = $user->mycompany->project;

        foreach ($projectlist as $proj) {
            array_push($myproject, $proj['id']);
        }

        $myfollows=array();
        $followlist = Follower::model()->findAll('email = "'.$user->email.'" and confirmed = 1');
        foreach ($followlist as $follow) {
array_push($myfollows,$follow->id);

        }


// If I am a follower then set the release to the last release.
        if (in_array($id,$myfollows)) {

            Yii::app()->session['project'] = $id;
            Yii::app()->session['projectOwner']=0;
        }
// if I own the project set the viewing release to current release
        if (in_array($id, $myproject)) {

            Yii::app()->session['project'] = $id;
            Yii::app()->session['projectOwner']=1;
        }


        if (Yii::app()->session['project'] ==$id) {
            $this->redirect(('/project/view/'));
        } ELSE {
            $this->redirect(('/site/index'));
        }
    }



    public function actionView()
    {

$this->render('view');


    }


    public function actionReport()
    {

        try {
            $user = User::model()->findbypk(Yii::App()->user->id);
            $company = Company::model()->findbyPk($user->company_id);
               $project = Project::model()->findbyPk(Yii::app()->session['project']);
            $endTimestamp = time();//today;
            $startTimestamp = time()-2592000;//today -30days

           if(isset($_POST['Date'])){

                $sM = $_POST['Date']['start_month'];
                $sD = $_POST['Date']['start_day'];
                $eM = $_POST['Date']['end_month'];
                $eD = $_POST['Date']['end_day'];
               // echo 'start month: '.$sM.' start day: '.$sD.' endDay: '.$eD.' endMonth: '.$eM;die;
                $year = date("Y",time());
                $stringEndDate = $year.'-'.$eM.'-'.$eD.' 23:59:59';
                $stringStartDate = $year.'-'.$sM.'-'.$sD.' 00:00:00';
                $endTimestamp  = strtotime($stringEndDate);
                $startTimestamp = strtotime($stringStartDate);
            }


           
             $endDatetime = date("Y-m-d 23:59:59",$endTimestamp);
    
             $startDatetime =  date("Y-m-d 00:00:00",$startTimestamp);
            
            // echo ' end '.$endDatetime.' start '.$startDatetime;die;
            $systemlist = Project::model()->getSystemsList($project->id);

            $data['scheduled'] = Config::model()->findAll(array('condition' => 'processrun_id is not null and system_id in '.$systemlist.' and deleted =0 and create_date> "'.$startDatetime.'" and create_date < "'.$endDatetime.'"'));

            $data['nonscheduled'] = Config::model()->findAll(array('condition' => 'processrun_id is null and system_id in '.$systemlist.' and deleted =0 and create_date> "'.$startDatetime.'" and create_date < "'.$endDatetime.'"'));

        
     
        
        
            } catch (Exception $ex) {
            
               echo 'exception: ' . $ex->getMessage();
               die;
            
            }
                $this->render('report', array(
                   'startTimestamp'=>$startTimestamp, 'endTimestamp'=>$endTimestamp, 'data'=>$data,'user'=>$user, 'company'=>$company
                ));
        

    }


    public function actionHistory($del=0)
    {

        $this->render('history',array('del'=>$del));


    }


    public function actionCreate()
    {
        $model = new Project;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Project'])) {
            $model->attributes = $_POST['Project'];
            $model->company_id = User::model()->myCompany();
            $model->extlink = md5(uniqid(rand(), true));
            $model->stage = 1;
            if ($model->save())
            $project = $model->getPrimaryKey();
            Yii::app()->session['project'] = $project;
            $this->redirect('/');


        }

        $this->render('create', array(
            'model' => $model,

        ));


    }

    public function actiongetProcessOptions($vars)
    {
        $user = User::model()->findbyPK(Yii::App()->user->id);
        $data = $user->mycompany->project;
        $allProjects = [];
        foreach($data as $project){
            array_push($allProjects,$project->id);
        }
        if(!in_array($vars,$allProjects)) die; // security check

        $model = Project::model()->findbypk($vars);
        $processes = $model->processes;
        echo '<select name="process">';
        foreach ($processes as $process){
            echo '<option value="'.$process->id.'">'.$process->name.'</option>';

        }
        echo '</select><br/><input type="submit" value="Add">';

    }
    public function actioncopyProcess()
    {
     try {
        $project=Project::model()->findByPk($_GET['project']);
        $process=Process::model()->findByPk($_GET['process']);
        if(is_null($process)) throw new Exception("No such process");
        if(is_null($project)) throw new Exception("No such project");
        $newProcess = new Process;
        $newProcess->attributes = $process->attributes;
        $newProcess->project_id = Yii::App()->session['project'];
        $newProcess->ext = md5(uniqid(rand(), true));
        $newProcess->active = 1;
        $newProcess->save();

        $newProcessId = $newProcess->getPrimaryKey();

        $steps = Processstep::model()->findAll('process_id = '.$process->id);
        foreach($steps as $step){
            $newStep = new Processstep;
            $newStep->attributes = $step->attributes;
            $newStep->process_id = $newProcessId;
            $newStep->ext = md5(uniqid(rand(), true));
            $newStep->save();
        }

    } catch (Exception $ex) {
    echo 'Error '.$ex; 
    die;
    }
$this->redirect('/process/view/id/'.$newProcess->ext);

    }
    public function actionUnlink($id)

    {
        $model=Projectsystem::model()->find('system_id = '.$id.' and project_id = '.Yii::App()->session['project']);
        $model->deleted=1;
        $model->save();
        $this->redirect('/project/view');


    }

    public function actionDelete()

    {
        $model=Project::model()->findByPk(Yii::App()->session['project']);
        $model->deleted=1;
        if($model->save()) {


        $this->redirect('/');
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



    public function actiongetSystemOptions($projectId)
    {
        try {

        $project = $this->loadModel($projectId);

        if(!(Project::model()->permissions(Yii::App()->user->id,$project->id)))
        throw new Exception('no permissions');

        $systems  = Project::model()->getSystems($project->id);



        $result  = '<option value="-1">None</option>';
        
        foreach ($systems as $system) {
            $result .= '<option value="'.$system->id.'">'.$system->name.'</option>';
        }

        echo $result;


        
        } catch (Exception $ex) {
            echo 'exception: ' . $ex->getMessage();
            die;
        } 

    }




    public function loadModel($id)
    {
        $model=Project::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}
