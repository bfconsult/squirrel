<?php

$project=Project::model()->findbyPK(Yii::App()->session['project']);

echo '<h1>'.$project->name;
?>
    <a href = "/project/view"><i class="icon-arrow-left"></i></a></h1>

<?php

$data = $configs;
    echo '<h2>'.$configs->parent_system->name.'</h2>';

    echo 'Created: '.$data->creator->firstname; ?> : <?php echo $data->create_date;


//echo '<pre>';
//print_r($data);

    $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => 'Configuration Record',
        'headerIcon' => 'icon-cogs',
        // when displaying a table, if we include bootstra-widget-table class
        // the table will be 0-padding to the box
        'htmlOptions' => array('class' => 'bootstrap-widget-table'),
        'headerButtons' => array(

            array(
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'label' => 'Edit Config',

                'url' => UrlHelper::getPrefixLink('/config/edit/id/'.$data->id),
            ),

        )
    ));
    if (!empty($data)) {

    ?>
    <table class="table">

        <tbody>


                <tr class="odd">
                    <td>
                        <?php echo $data->name; ?>
                       
                  <br />
                        - <?php echo $data->description; ?>
                        <br />
                        - <?php if (!is_null($data->processrun_id)) {
                            $processRun=Processrun::model()->findbyPK($data->processrun_id);
                            echo 'Process run result was '.Processrun::$result[$processRun->status].' <a href="/processrun/view/id/'.$processRun->ext.'">View Process Run</a>';
                        } ?>
                    </td>


                </tr>

        </tbody>
    </table>

    <?php }
$this->endWidget();



?>