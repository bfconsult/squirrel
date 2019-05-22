<?php

$project=Project::model()->findbyPK(Yii::App()->session['project']);

echo '<h1>'.$project->name;
?>
    <a href = "/project/view"><i class="icon-arrow-left"></i></a></h1>



    <h2>Log Time</h2>



<?php 

echo $this->renderPartial('_form', array('model'=>$model,'project'=>$project,'endMonth'=>$endMonth,'endYear'=>$endYear, 'endDay'=>$endDay, 'endHour'=>$endHour)); ?>