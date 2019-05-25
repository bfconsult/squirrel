
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'system-form',
	'enableAjaxValidation'=>false,
   
    
)); 

?>
 	<div class="row ">
            <p class="note">Fields with <span class="required">*</span> are required.</p>

</div>
<div>
            <?php if(!is_null($project_id)){ ?>
            <input type="hidden" name="Time[project_id]" value=<?php echo $project_id; ?>>
        <?php } ELSE {
            
            $projects = Project::model()->findAll('company_id='.$user->company_id);
                        
            ?>
        Pick Project
            
            <select id="project-select" name="Time[project_id]">
            <?php foreach($projects as $project){ 
            echo '<option value="'.$project->id.'">'.$project->name.'</option>';
            }?>
            </select>
        <?php } ?>
</div>
<div>
            <?php if(!is_null($system_id)){ ?>
            <input type="hidden" name="Time[system_id]" value=<?php echo $system_id; ?>>
        <?php } ELSEif (is_null($project_id)) {?>
        Pick System
    
            <select  id="system-select" name="Time[system_id]">
            <option value="-1">None</option>
            </select>
        <?php } ELSE { ?>
            <select  id="system-select" name="Time[system_id]">
       <?php    $systems  = Project::model()->getSystems($project->id);
            $result  = '<option value="-1">None</option>';

            foreach ($systems as $system) {
                $result .= '<option value="'.$system->id.'">'.$system->name.'</option>';
            }

            echo $result; ?>
         </select>
        <?php } ?>

        </div>
<div>

	<?php echo $form->errorSummary($model); ?>
 	</div>    
        <?php if(!is_null($config_id)){ ?>
            <input type="hidden" name="Time[config_id]" value=<?php echo $config_id; ?>>
        <?php } ELSE {?>
            <input type="hidden" name="Time[config_id]" value="-1">
        <?php } ?>

        </div>






     <div class="row">
        Time Entry Duration
    </div>

     <div class="row">
     <div class="span1"><select  class="input-mini" name="Time[duration_hour]">
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>


            </select></div>
     <div class="span1"><select  class="input-mini" name="Time[duration_minute]">
            <option value="0">:00</option>
            <option value="15">:15</option>
            <option value="30" selected>:30</option>
            <option value="45">:45</option>
            </select></div>

    </div>




     <div class="row">
     End time of entry
    </div>
    <div class="container">
        <div class="row">
            <div class="span1">Day</div>
            <div class="span1"><input type="text"  class="input-mini"  name="Time[end_year]" value="<?php echo $endYear; ?>"></div>
   
            <div class="span1">
            <select  class="input-mini" name="Time[end_month]">
            <?php for($m=1; $m <13 ; $m++) { ?>
            <option value="<?php echo $m; ?>" <?php if ($m == $endMonth) echo 'selected'; ?>  >
            <?php echo date("M", mktime(0, 0, 0, $m, 10));?>
            </option>
            <?php }  ?>
            </select>
            </div>


            <div class="span1"><input type="text"  class="input-mini"  name="Time[end_day]" value="<?php echo $endDay; ?>"></div>

        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="span1">Time</div>
            <div class="span1"><input type="text"  class="input-mini" name="Time[end_hour]" value="<?php echo $endHour; ?>"></div>
            <div class="span1">:<select  class="input-mini" name="Time[end_minute]">
            <option value="0">00</option>
            <option value="15">15</option>
            <option value="30">30</option>
            <option value="45">45</option>
            </select></div>
        </div>
    </div>


	<div class="row ">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textField($model,'note',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'note'); ?>
	</div>

       
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->



