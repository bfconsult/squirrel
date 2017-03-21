<?php

class ConfigController extends Controller
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
                'actions' => array('view','edit','create'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

//used to sort arrays in the print diagram view




    public function actionView($id)
    {

    $configs=$this->loadModel($id);
    $this->render('view',array('configs'=>$configs));


    }



    public function actionCreate($id)
    {
        $model = new Config;


        if (isset($_POST['Config'])) {
            $model->attributes = $_POST['Config'];
            $model->create_user = Yii::App()->user->id;
            $model->system_id=$id;
            $model->number = Config::model()->getNextNumber($id);
            if ($model->save())

                $this->redirect('/system/view/id/'.$id);


        }

        $this->render('create', array(
            'model' => $model,

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
