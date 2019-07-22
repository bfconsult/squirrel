<?php

$project=Project::model()->findbyPK(Yii::App()->session['project']);
$system = System::model()->findbyPK($process->system_id);
echo '<h1>'.$project->name;
?>
    <a href = "/project/view"><i class="icon-arrow-left"></i></a>
    
    
    </h1>

<?php

    echo '<h2>Process: '.$process->name.' <a href="/process/edit/ext/'.$process->ext.'"><i class="icon-edit"></i></a></h2>';
    if($process->type==1){
    echo '<h3>System: '.$system->name.'</h3>';
echo 'Repeats: ';
echo (isset(Process::$frequencies[$process->frequency]))?Process::$frequencies[$process->frequency]:'Custom';
    }
$data = $process->steps;



//print_r($data);die;

    $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => 'Process Steps',
        'headerIcon' => 'icon-briefcase',
        // when displaying a table, if we include bootstra-widget-table class
        // the table will be 0-padding to the box
        'htmlOptions' => array('class' => 'bootstrap-widget-table'),
        'headerButtons' => array(

            array(
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'success', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'label' => 'Add Step  +',

                'url' => UrlHelper::getPrefixLink('/processstep/create/id/'.$process->ext),
            ),

        )
    ));
    if (!empty($data)) {    ?>


    <table class="table">

    <tbody>

<?php foreach ($data as $item){ ?>
        <tr class="odd">
            <td>
            <?php echo $item->number; ?>
            </td>
            
            <td>
            <?php echo $item->action; ?>
            </td>
            <td>
            <?php echo $item->result; ?>
            </td>
            <td>  
            <a href="/processstep/edit/id/<?php echo $item->id; ?>"><i class="icon-edit"></i></a>
          
            <a href="/processstep/delete/id/<?php echo $item->id; ?>"><i class="icon-remove-sign"></i></a>
            </td>
        </tr>

<?php } ?>

    </tbody>
    </table>

    <?php }
$this->endWidget();




$data = $process->runs;

 

//print_r($data);die;

    $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => 'Process Runs',
        'headerIcon' => 'icon-briefcase',
        // when displaying a table, if we include bootstra-widget-table class
        // the table will be 0-padding to the box
        'htmlOptions' => array('class' => 'bootstrap-widget-table'),
        'headerButtons' => array(

            array(
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'label' => 'Run',

                'url' => UrlHelper::getPrefixLink('/process/run/id/'.$process->ext),
            ),
        )
    ));
    if (!empty($data)) {    ?>


    <table class="table">

    <tbody>

<?php foreach ($data as $item){ ?>
        <tr class="odd">
            <td>
            <?php echo $item->number; ?>
            </td>
            
            <td>
            <?php echo Processrun::$result[$item->status]; ?>
            </td>
            <td>
            <a href="/processrun/view/id/<?php echo $item->ext; ?>">View</a>
            </td>
           
        </tr>

<?php } ?>

    </tbody>
    </table>

    <?php }
$this->endWidget();


?>