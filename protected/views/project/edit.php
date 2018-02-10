<h1>Edit Project</h1>



<?php 

echo $this->renderPartial('_form', array('model'=>$model)); ?>


Collaborators



<?php
$followers = Follower::model()->findAll('project_id='.Yii::App()->session['project']);
$user = User::model()->findByPk(Yii::App()->user->id);
echo $this->renderPartial('_followers', array('model'=>$model,'followers'=>$followers,'user'=>$user)); ?>

