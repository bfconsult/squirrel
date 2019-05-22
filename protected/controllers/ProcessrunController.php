<?php

class ProcessrunController extends Controller
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
        $processrun=Processrun::model()->find('ext = :ext',[':ext'=>$id]);

        if(is_null($processrun)){echo 'no such process run';die;}

        $process=Process::model()->findbyPk($processrun->process_id);

        $this->render('view',['processrun'=>$processrun,'process'=>$process]);


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
