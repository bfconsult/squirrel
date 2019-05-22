<?php

class TimeController extends Controller
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
                'actions' => array('view','viewdetail','edit','log','delete'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

//used to sort arrays in the print diagram view







    public function actionDelete($id)
    {

        $config=Config::model()->findByPk($id);
        $link=Projectsystem::model()->find('system_id ='.$config->system_id.' and project_id = '.Yii::App()->session['project']);
        if (!is_null($link))
            $config->deleted = 1;
        $config->save();
        $this->redirect('/project/history');


    }

    public function actionLog($config=null,$system=null)
    {
        $model = new Time;
        if (!is_null($config) && is_null($system )){
            $config = Config::model()->findbyPk($config);
        $system = $config->system_id;
        } ELSE {
$config = null;

        }
        $project = Project::model()->findbyPk(Yii::App()->session['project']);
       // print_r($project);die;

        if (isset($_POST['Time'])) {
            $endYear = $_POST['Time']['end_year'];
            $endMonth = $_POST['Time']['end_month'];
            $endDay = $_POST['Time']['end_day'];
            $hourEnd = $_POST['Time']['end_hour'];
            $minuteEnd = $_POST['Time']['end_minute'];
            $durationHour = $endHour = $_POST['Time']['duration_hour'];
            $durationMinute = $_POST['Time']['duration_minute'];
     


// make the end out of the stuff we got.
$stringEndDate = $endYear.'-'.$endMonth.'-'.$endDay.' '.$hourEnd.':'.$minuteEnd.':00';
//echo 'string end date '.$stringEndDate.'<br>';
$endDate = strtotime($stringEndDate);

$endFormatDate = date("Y-m-d H:i:s",$endDate);
// work out the start from the ned

$duration = (3600*$durationHour)+(60*$durationMinute);
$startDate = $endDate-$duration;
$startFormatDate = date("Y-m-d H:i:s",$startDate);

//echo 'start '.$startFormatDate.' - end date '.$endFormatDate;die;

            $model->system_id = $system;
            $model->config_id = $config->id;
            $model->note = $_POST['Time']['note'];
            $model->user_id = Yii::App()->user->id;
            $model->end = $endFormatDate;
            $model->start = $startFormatDate;
            if ($model->save())


                $this->redirect('/project/view/id/'.$project->id);

        }


        $endMonth=date('m',time());
        $endDay=date('d',time());
        $endHour=date('H',time());
        $endYear=date('Y',time());

        $this->render('log', array(
            'model' => $model,'project'=>$project,'config'=>$config,'endMonth'=>$endMonth, 'endDay'=>$endDay, 'endHour'=>$endHour,'endYear'=>$endYear,
        ));


    }


    public function actionViewDetail($config=null,$system=null) {
try {

    
       
       if (!is_null($config)) {
        $config = Config::model()->findbyPk($config);
        $configId = $config->id;
        $systemId = $config->system_id;
        $reportType = 'config';
        
        } ELSEIF (!is_null($system)) {
        $config = null;
        $configId = null;
        $system = System::model()->findbypk($system);   
        $reportType = 'system';
        } ELSE {
            $reportType = 'project';
            $configId = null;
            $systemId= null;
        }
        $project = Project::model()->findbyPk(Yii::App()->session['project']);
       // print_r($project);die;

$allTimes = Time::model()->getAllProjectTime($project->id);
/*
$stringEndDate = $endYear.'-'.$endMonth.'-'.$endDay.' '.$hourEnd.':'.$minuteEnd.':00';
$endDate = strtotime($stringEndDate);
$endFormatDate = date("Y-m-d H:i:s",$endDate);
$duration = (3600*$durationHour)+(60*$durationMinute);
$startDate = $endDate-$duration;
$startFormatDate = date("Y-m-d H:i:s",$startDate);
*/


// go through the times and get the relevant ones.





    } catch (Exception $ex) {
    
       echo 'exception: ' . $ex->getMessage();
       die;
    
    }
        $this->render('view', array(
           'project'=>$project,'config'=>$configId,'system'=>$systemId, 'times'=>$allTimes, 'type'=>$reportType
        ));

    
    }


    public function loadModel($id)
    {
        $model=Config::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

}
