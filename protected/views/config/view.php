Project

<?php $project=Project::model()->findbyPK(Yii::App()->session['project']);

echo $project->name;




$data = $configs;
//echo '<pre>';
//print_r($data);

    $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => 'Recent Projects',
        'headerIcon' => 'icon-briefcase',
        // when displaying a table, if we include bootstra-widget-table class
        // the table will be 0-padding to the box
        'htmlOptions' => array('class' => 'bootstrap-widget-table'),
        'headerButtons' => array(

            array(
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'success', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'label' => 'Add Config  +',

                'url' => UrlHelper::getPrefixLink('/config/create'),
            ),

        )
    ));
    if (!empty($data)) {

    ?>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>


        </tr>
        </thead>
        <tbody>
        <?php if (count($data)): ?>





                <tr class="odd">
                    <td>
                        <?php echo
                        $data->name; ?>
                        - <?php echo $data->description; ?>
                    </td>


                </tr>



        <?php endif; ?>


        </tbody>
    </table>

    <?php }
$this->endWidget();



?>