<h1>Create a New <?php echo Process::$typeName[$process->type] ;?> Step</h1>



<?php 

$projectId=Yii::app()->session['project'];
$project=Project::model()->findByPk($projectId);
if (is_null($project)) {'echo no project';die;}
            echo '<h3>'.$project->name.'</h3';

echo $this->renderPartial('_form', array('model'=>$model,'project'=>$project,'process'=>$process)); ?>