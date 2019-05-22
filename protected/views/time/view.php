<?php

$project=Project::model()->findbyPK(Yii::App()->session['project']);

echo '<h1>'.$project->name;
?>
    <a href = "/project/view"><i class="icon-arrow-left"></i></a></h1>

<?php

    echo '<h2>Timesheet View (Detail)</h2>';




$data = $times;
//echo '<pre>';
//print_r($data);

    $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => 'Time Entries',
        'headerIcon' => 'icon-calendar',
        // when displaying a table, if we include bootstra-widget-table class
        // the table will be 0-padding to the box
        'htmlOptions' => array('class' => 'bootstrap-widget-table'),
        'headerButtons' => array(

            array(
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'success', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'label' => 'Add Time  +',

                'url' => UrlHelper::getPrefixLink('/time/log'),
            ),

        )
    ));

//echo '<pre>';
//print_r($data);
//echo '</pre>';

if ($type == 'config') {
    $data = $times['config'][$config];
} ELSEIF ($type == 'system') {
    $data = $times['system'][$system];
} ELSE {
    
    $data = [];
    foreach( $times['system'] as $detailData){
        foreach ($detailData as $detail){
            array_push($data, $detail);
        }
    }
 
}




    if (!empty($data)) {

    ?>
    <table class="table">

        <tbody>
      <?php foreach ($data as $item): ?>

                <tr class="odd">
  
                    <td>
                        <?php echo $item['start']; ?> : <?php echo $item['end']; ?>
                    </td>
                  <td>
                        <?php echo $item['duration']; ?>
                    </td>
                  <td>
                        <?php echo $item['note']; ?>
                    </td>
                </tr>



      <?php endforeach ?>

        </tbody>
    </table>

    <?php }


$this->endWidget();



?>