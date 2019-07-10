<?php

$project=Project::model()->findbyPK(Yii::App()->session['project']);

echo '<h1>'.$project->name;
?>
    <a href = "/project/view"><i class="icon-arrow-left"></i></a></h1>

<?php

    echo '<h2>Process: '.$process->name.'</h2>';

$data = $process->steps;

if(count($process->runs)){
  echo '<a href="#">Runs</a>';
     }  ELSE {
echo "Not Run";

    }
   

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
                'type' => 'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'label' => 'Cancel',

                'url' => UrlHelper::getPrefixLink('/process/view/id/'.$process->ext),
            ),
        )
    ));
    if (!empty($data)) {    ?>

<form action='/process/run/id/<?php echo $process->ext; ?>' name='ProcessRun' method='POST'>

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
            <td>Expected:
            <?php echo $item->result; ?>
            </td>
            <td>
       
           Done: <input type='checkbox' name='done[<?php echo $item->id;?>]'>
            </td>
           
            <td>
           Notes <textarea name='note[<?php echo $item->id;?>]'></textarea>
            </td>
  
        </tr>

        <?php } ?>
        <tr>
        <td><select name="Status">
            <option value="1">Successfully completed</option>
            <option value="0">Failed to complete</option>
        </select>
        Report summary:<br/> <textarea name='summary'></textarea>
        <input type='submit' value='done' name='ProcessRun'>
        </td>
        </tr>

    </tbody>
    </table>
</form>
    <?php }
$this->endWidget();

?>