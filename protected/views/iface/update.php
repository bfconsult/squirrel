
<?php 
echo $this->renderPartial('/project/head',array('tab'=>'usecases')); ?>

<h2>Interface UI-<?php echo str_pad($model->number, 3, "0", STR_PAD_LEFT); ?> </h2>
    <h3><?php echo str_pad($model->name, 3, "0", STR_PAD_LEFT); ?> </h3>
  

<?php $this->renderPartial('_form', array('model'=>$model,'id'=>$id)); ?>