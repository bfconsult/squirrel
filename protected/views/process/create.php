<h1>Add a Process</h1>



<?php 

$projectId=Yii::app()->session['project'];
$project=Project::model()->findByPk($projectId);
$processes = Process::model()->findAll('project_id = '.$projectId.' and active = 1');
if (is_null($project)) {'echo no project';die;}
echo '<h3>'.$project->name.'</h3>'; ?>

<div class="wrapper" style=" display: flex; display: -webkit-flex; flex-direction: row;">
    <div class="flexrow">
    <h4> Create New </h4>
    <?php
    echo $this->renderPartial('_form', array('model'=>$model,'project'=>$project)); ?>
    </div>

    <div class="flexrow" style="margin-left:24px;">
    <h4>List of existing processes</h4>
<?php
foreach($processes as $process){

    echo $process->name.'<br>';
}

?>
    </div>
</div>

<div style="display:block;" class="form">

<h4> Copy from another project</h4>
<?php
$user = User::model()->findbyPK(Yii::App()->user->id);
$data = $user->mycompany->project;

?>

<form action="/project/copyProcess">
<select name="project" id="project">
<?php
foreach ($data as $project){
    if(count($project->processes)){
echo '<option value="'.$project->id.'">'.$project->name.'</option>';
}}
?>
</select>
<div id="processes"></div>
</form>

</div>


<script>
$(document).ready(function(){
    
    $('#project').change(function() {
        var e = document.getElementById('project');
           var project = this.options[e.selectedIndex].value;
            $('#actor-select').html('<option>Loading ...</option>');

            $.ajax({
                url: '<?php echo CController::createUrl("/project/getProcessOptions?vars=")?>' + project,
                type: 'GET',
                success: function(response) {
                    $('#processes').html(response);
                   
                    }
            });
            

            
        });





});

</script>