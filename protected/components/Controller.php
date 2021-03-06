<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    
    protected function beforeAction($action)
	{
        $controller=Yii::app()->controller->id;
        $action=$action->id;
        if (!($controller == 'user' && $action == 'join') && 
         !($controller == 'user' && $action == 'accept') &&
         !($controller == 'user' && $action == 'active') &&
         !($controller == 'user' && $action == 'welcome') &&
         !($controller == 'user' && $action == 'joinsuccess') &&
         !($controller == 'user' && $action == 'joinfollower') &&
            !($controller == 'user' && $action == 'newaccount') &&
            !($controller == 'user' && $action == 'mailchimp') &&
         !($controller == 'follower' && $action == 'accept') &&
         !($controller == 'project' && $action == 'extview') &&
          !($controller == 'site' && $action == 'terms') &&
         !($controller == 'site' && $action == 'contact') &&
         !($controller == 'site' && $action == 'support') &&
         !($controller == 'site' && $action == 'fail') &&
         !($controller == 'site' && $action == 'privacy') &&
         !($controller == 'site' && $action == 'login') &&
         !($controller == 'site' && $action == 'forgotpassword') &&
         !($controller == 'site' && $action == 'newpassword') &&
         !($controller == 'reset' && $action == 'index') &&
         !($controller == 'reset' && $action == 'success') && 
         !($controller == 'ajax' && $action == 'login')
             )
        {
            if (Yii::app()->user->isGuest) {
                Yii::app()->user->setFlash('notice', "Please log in or register");
                $this->redirect('/site/login/');
            }




        }



        return parent::beforeAction($action);
	}

    public function behaviors() {
        return array(
            'BodyClassesBehavior' => array(
                'class' => 'ext.yii-body-classes.BodyClassesBehavior'
            ),
        );
    }
}