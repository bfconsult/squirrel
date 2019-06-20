<?php

$project=Project::model()->findbyPK(Yii::App()->session['project']);

echo '<h1>'.$project->name;
?>
    <a href = "/project/view"><i class="icon-arrow-left"></i></a></h1>

<?php

    echo '<h2>Process: '.$process->name.'</h2>';

$steps = $process->steps;

$results = $processrun->results;

echo 'Last completed: '.Processrun::completeDate($process->id);
   

//echo '<pre>';print_r($processrun);die;

    $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => 'Run Results',
        'headerIcon' => 'icon-briefcase',
        // when displaying a table, if we include bootstra-widget-table class
        // the table will be 0-padding to the box
        'htmlOptions' => array('class' => 'bootstrap-widget-table'),
        'headerButtons' => array(

          
        )
    ));
    if (!empty($results)) {    ?>


    <table class="table">

    <tbody>

<?php foreach ($results as $item){ ?>
        <tr class="odd">
            <td>
            <?php echo $item->step->number; ?>
            </td>
            <td>
            <?php echo $item->step->action; ?>
            </td>
            <td>
            <?php echo $item->comments; ?>
            </td>
            <td>
            <?php echo Processresult::$result[$item->result]; ?>
            </td>
           
        </tr>

<?php } ?>

    </tbody>
    </table>

    <?php }
$this->endWidget();




?>