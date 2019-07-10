
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'system-form',
	'enableAjaxValidation'=>false,
   
    
)); 

?>
 	<div class="row ">
            <p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
 	</div>      
	<div class="row ">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row ">
		<select name="Config[system_id]" id="system_id">
			<?php
			$systems= $project->systems;

			foreach ($systems as $system){
				if ($system->deleted == 0){

				?>

				<option value="<?php echo $system->id?>"><?php echo $system->name?></option>
			<?php
				}
			}

		?>

		</select>
	</div>

        <div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<?php if(!$model->isNewRecord){
$existDate=strtotime($model->create_date);
$year = date("Y",$existDate);
$month = date("m",$existDate);
$day =date("d",$existDate);
$hour = date("H",$existDate);
$min = date("i",$existDate);

?>

<div class="row">
   

		
  

   
   
                <select  class="input-mini" name="day">
                <?php for($m=1; $m <31 ; $m++) { ?>
                <option value="<?php echo $m; ?>"  <?php if ($m == $day) echo 'selected'; ?>  >
                <?php echo $m;?>
                </option>
                <?php }  ?>
                </select>

				<select  class="input-mini" name="month">
                <?php for($m=1; $m <13 ; $m++) { ?>
                <option value="<?php echo $m; ?>"  <?php if ($m == $month) echo 'selected'; ?>  >
                <?php echo date("M", mktime(0, 0, 0, $m, 10));?>
                </option>
                <?php }  ?>
                </select>
				
				<select  class="input-small" name="year">
				<?php for($m=$year-1; $m < $year+2 ; $m++) { ?>
                <option value="<?php echo $m; ?>"  <?php if ($m == $year) echo 'selected'; ?>  >
                <?php echo $m;?>
                </option>
                <?php }  ?>
                </select>
				Time:

				<select  class="input-mini" name="hour">
                <?php for($m=1; $m <25 ; $m++) { ?>
                <option value="<?php echo $m; ?>"  <?php if ($m == $hour) echo 'selected'; ?>  >
                <?php echo $m;?>
                </option>
                <?php }  ?>
                </select>
				<select  class="input-mini" name="min">
                <?php for($m=1; $m < 61 ; $m++) { ?>
                <option value="<?php echo $m; ?>"  <?php if ($m == $min) echo 'selected'; ?>  >
                <?php echo $m;?>
                </option>
                <?php }  ?>
                </select>

</div>

	<?php } ?>
        
       

       
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
