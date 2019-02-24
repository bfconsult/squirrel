
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'project-form',
	'enableAjaxValidation'=>false,
   
    
)); 

?>
 	<div class="row ">
            <p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
 	</div>      
	<div class="row ">
		<?php echo $form->labelEx($model,'action'); ?>
		<?php echo $form->textArea($model,'action',array('rows'=>10,'cols'=>120)); ?>
		<?php echo $form->error($model,'action'); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'result'); ?>
		<?php echo $form->textArea($model,'result',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'result'); ?>
	</div>
	<div class="row ">
		<?php echo $form->labelEx($model,'link'); ?>
		<?php echo $form->textField($model,'link',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'link'); ?>
	</div>
       

       
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
