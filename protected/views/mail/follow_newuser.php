<?php echo $follower->firstname.',
            <br /><br />
            You\'ve been invited to follow a Squirrel project.You can follow the link below
            to create an account on Squirrel and to get access to project resources.
            <br />
            Click here to accept <a href="'.Yii::app()->params['protocol'].Yii::app()->params['server'].'/follower/accept/id/'.$follower->link.'">'.Yii::app()->params['protocol'].Yii::app()->params['server'].'/follower/accept/id/'.$follower->link.'</a>
            <br />
             You can access the project documents without logging in directly here:
            <a href="'.Yii::app()->params['protocol'].Yii::app()->params['server'].'/project/model/ext/'.$extlink.'">'.Yii::app()->params['protocol'].Yii::app()->params['server'].'/project/extview/id/'.$extlink.'</a>';
?>