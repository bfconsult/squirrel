<?php

//echo Yii::App()->session['project']; die;

$project=Project::model()->findbyPK(Yii::App()->session['project']);
$times = Time::model()->getAllProjectTime($project->id);

echo '<h1>'.$project->name;

if (Yii::App()->session['projectOwner']==1) {
    ?>

    <a href="/project/edit"><i class="icon-edit"></i></a>
    <a href="/project/delete" onclick="return confirm('Are you sure you want to delete this project?');"><i class="icon-remove-sign"></i></a>
    <a href="/time/viewdetail"><i class="icon-calendar"></i></a>
    <?php
}
    ?>


    </h1>
<?php






$startMonth = date("m",$startTimestamp);
$startDay =date("d",$startTimestamp);
$endMonth = date("m",$endTimestamp);
$endDay = date("d",$endTimestamp);

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
        'title' => 'Configuration and maintenance report '. date("Y-m-d", $startTimestamp).' to '. date("Y-m-d", $endTimestamp),
        'headerIcon' => 'icon-briefcase',
        // when displaying a table, if we include bootstra-widget-table class
        // the table will be 0-padding to the box
        'htmlOptions' => array('class' => 'bootstrap-widget-table'),
        'headerButtons' => array()

    ));

    ?>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>


        </tr>
        </thead>
        <tbody>
        <?php if (count($data['scheduled'])): ?>

<tr><td><h4>Scheduled Tasks</h4></td></tr>
            <?php foreach ($data['scheduled']  as $item): ?>


                <tr class="odd">
                    <td>
                        
                        name: <?php echo $item->name; ?>(<?php echo $item->id; ?>)<br/>
                        description: <?php echo $item->description; ?>
                        processrun: <?php echo $item->processrun->id; ?>
                        <?php if (count($item->processrun->results)) {
                            foreach($item->processrun->results as $result){
                                echo $result->comments;
                            }


                        }; ?>
                    </td>
       
                 
                    <td>
                        <?php echo $item->create_date; ?>
                    </td>

                </tr>
                <?php

            endforeach;
        endif;

        ?>



<?php if (count($data['nonscheduled'])): ?>

<tr><td><h4>Non-Scheduled Tasks</h4></td></tr>
<?php foreach ($data['nonscheduled']  as $item): ?>


    <tr class="odd">
        <td>
            <?php echo $item->id; ?>
            <?php echo $item->name; ?>
            <?php echo $item->description; ?>
        </td>

     
        <td>
            <?php echo $item->create_date; ?>
        </td>

    </tr>
    <?php

endforeach;
endif;

?>


        </tbody>
    </table>

    <?php





$this->endWidget();

?>