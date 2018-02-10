<?php echo $follower->firstname.',
<br /><br />
You\'ve been invited to follow a Squirrel project.
<br />As you already have a Squirrel account, just click the link below to get instant access to the project.
<br />
Click here to accept <a href="'.Yii::app()->params['protocol'].Yii::app()->params['server'].'/follower/accept/id/'.$follower->link.'">'.Yii::app()->params['protocol'].Yii::app()->params['server'].'/follower/accept/id/'.$follower->link.'</a>
<br />
You can access the project documents without logging in directly here:
<a href="'.Yii::app()->params['protocol'].Yii::app()->params['server'].'/project/model/ext/'.$extlink.'">'.Yii::app()->params['protocol'].Yii::app()->params['server'].'/project/extview/id/'.$extlink.'</a>';
?>