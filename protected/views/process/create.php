<h1>Create a New Process</h1>



<?php 

$projectId=Yii::app()->session['project'];
$project=Project::model()->findByPk($projectId);
if (is_null($project)) {'echo no project';die;}
            echo '<h3>'.$project->name.'</h3';

echo $this->renderPartial('_form', array('model'=>$model,'project'=>$project)); ?>
<div class="form">

<h2> Copy from another project</h2>
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