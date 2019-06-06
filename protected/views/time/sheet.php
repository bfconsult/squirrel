<?php

echo '<h1>'.$company->name;
?>
    <a href = "/"><i class="icon-arrow-left"></i></a></h1>

<?php

    echo '<h2>Timesheet View</h2>';




$data = $times;
//echo '<pre>';
//print_r($data);
//die;

$startMonth = date("m",$startTimestamp);
$startDay =date("d",$startTimestamp);
$endMonth = date("m",$endTimestamp);
$endDay = date("m",$endTimestamp);

?>
<div class="row">

<div class="span1">
From: 
</div>
    <div class="span2">
        <form method="POST" action="">
              
                <select  class="input-mini" name="Date[start_month]">
                <?php for($m=1; $m <13 ; $m++) { ?>
                <option value="<?php echo $m; ?>"  <?php if ($m == $startMonth) echo 'selected'; ?>  >
                <?php echo date("M", mktime(0, 0, 0, $m, 10));?>
                </option>
                <?php }  ?>
                </select>
   
                <select  class="input-mini" name="Date[start_day]">
                <?php for($m=1; $m <31 ; $m++) { ?>
                <option value="<?php echo $m; ?>"  <?php if ($m == $startDay) echo 'selected'; ?>  >
                <?php echo $m;?>
                </option>
                <?php }  ?>
                </select>
                
        </div>
    <div class="span1">
To:
</div>
<div class="span2">
            <select  class="input-mini" name="Date[end_month]">
            <?php for($m=1; $m <13 ; $m++) { ?>
            <option value="<?php echo $m; ?>" <?php if ($m == $endMonth) echo 'selected'; ?> >
            <?php echo date("M", mktime(0, 0, 0, $m, 10));?>
            </option>
            <?php }  ?>
            </select>
            
            <select  class="input-mini" name="Date[end_day]">
            <?php for($m=1; $m <31 ; $m++) { ?>
            <option value="<?php echo $m; ?>" <?php if ($m == $endDay) echo 'selected'; ?> >
            <?php echo $m;?>
            </option>
            <?php }  ?>
            </select>
    </div>
    <div class="span2">
            <input type="submit" class="btn-primary">
            </form>
    </div>

    <div class="span2 pull-right">
    <form method="POST" action="/time/download">

            <input type="hidden" name="startDate" value="<?php echo $startTimestamp; ?>">
            <input type="hidden" name="endDate" value="<?php echo $endTimestamp; ?>">
        
            <input type="submit" value = "download" class="btn-success">

            </form>
    </div>
</div>

<?php
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




    if (!empty($data)) {

$projectArray =  Project::model()->getProjectsNameArray();
$systemArray = System::model()->getSystemsNameArray();

//echo '<pre>';
//print_r($systemArray);
//die;

?>




    <table class="table">

        <tbody>
      <?php foreach ($data as $item):
        
        
$startTimestamp = strtotime($item['start']);
$endTimestamp = strtotime($item['end']);

$startFormatTime = date("H:i",$startTimestamp);
$startFormatDate = date("F j, Y",$startTimestamp);

$endFormatTime = date("H:i",$endTimestamp);
$duration = ($endTimestamp - $startTimestamp)/(60*60);
$item['project_id']=(is_null($item['project_id']))?-1:$item['project_id']; 
$item['system_id']=(is_null($item['system_id']))?-1:$item['system_id'];        

        ?>

                <tr class="odd">
                <td>
                        <?php echo $startFormatDate; ?>
                    </td>
                    <td>
                        <?php echo $projectArray[$item['project_id']]; ?>
                    </td>
                    <td>
                        <?php echo $systemArray[$item['system_id']]; ?>
                    </td>
                    <td>
                        <?php echo $startFormatTime.' - '.$endFormatTime; ?>
                    </td>
                  <td>
                        <?php echo $duration; ?>
                    </td>
                  <td>
                        <?php echo $item['note']; ?>
                    </td>
                    <td>
                        <a href="/time/edit/id/<?php echo $item['id']; ?>"><i class="icon-edit"></i></a>
                        <a href="/time/delete/id/<?php echo $item['id']; ?>"><i class="icon-remove-sign"></i></a>
                    </td>
                </tr>



      <?php endforeach ?>

        </tbody>
    </table>

    <?php }


$this->endWidget();



?>