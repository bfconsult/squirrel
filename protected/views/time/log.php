<?php

$project=Project::model()->findbyPK(Yii::App()->session['project']);

echo '<h1>'.$project->name;
?>
    <a href = "/project/view"><i class="icon-arrow-left"></i></a></h1>



    <h2>Log Time</h2>



<?php 

echo $this->renderPartial('_form', 
                array('model'=>$model,
                'project'=>$project,
                'endMonth'=>$endMonth,
                'endYear'=>$endYear, 
                'endDay'=>$endDay, 
                'endHour'=>$endHour,
                'user'=>$user,
                'project_id'=>$project_id,
                'system_id'=>$system_id,
                'config_id'=>$config_id,
                )); ?>


<script type="text/javascript">
    $(document).ready(function(){

        $('#project-select').change(()=>{
           // alert('yeah');
           const project=( $(this).find(":selected").val() );
            $('#system-select').html('<option>Loading ...</option>');

            $.ajax({
                url: '<?php echo CController::createUrl("/project/getSystemOptions?projectId=")?>' + project,
                type: 'GET',
                success: function(response) {
                    $('#system-select').html(response);
                    }
            });
        });
    
    //    $('#Addresses_country_id').change();
    });
</script>