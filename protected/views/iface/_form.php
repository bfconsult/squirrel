<?php
/* @var $this IfaceController */
/* @var $model Iface */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'iface-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
));


  //$interfacetypes = CHtml::listData(Interfacetype::model()->findAll('project_id='.$id), 'id', 'name');


?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>



	<?php echo $form->hiddenField($model,'photo_id'); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>


            <div class="row">

            <?php echo $form->labelEx($model,'text'); ?>
            <?php
                $this->widget('ImperaviRedactorWidget', array(
                    'model' => $model,
                    'options' => array(
                    'imageUpload' => $this->createUrl('/site/uploadimage')),
                    'attribute' => 'text'
                ));
            ?>
            </div>
        <br />
        <br />
        <div class="row">

             <?php $interfacetypes = Interfacetype::model()->getInterfacetypes();?>
             <select name="Iface[interfacetype_id]">
             <?php foreach($interfacetypes as $iface){?>

             <option class="span12" value="<?php echo $iface['interfacetype_id'];?>" 
                 <?php if($iface['interfacetype_id'] == $model->interfacetype_id)echo 'selected';?> >
                     <?php echo $iface['name'];?></option>
             <?php } ?>
             </select>

        </div>

	<div class="row">



	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
