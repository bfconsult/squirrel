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

$data = Config::model()->getRecentConfigs();


    $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => 'Recent Configuration Changes',
        'headerIcon' => 'icon-briefcase',
        // when displaying a table, if we include bootstra-widget-table class
        // the table will be 0-padding to the box
        'htmlOptions' => array('class' => 'bootstrap-widget-table'),
        'headerButtons' => array(


            array(
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'label' => 'View History',

                'url' => UrlHelper::getPrefixLink('/project/history/'),
            ),
            array(
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'success', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'label' => 'Add Configuration  +',

                'url' => UrlHelper::getPrefixLink('/config/create/'),
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


            <?php foreach ($data as $item): ?>


                <tr class="odd">
                    <td>
                        <a href="/config/view/id/<?php echo $item->id; ?>"><?php echo $item->name; ?></a>
                        - <?php echo $item->description; ?>
                    </td>
                    <td>
                    <a href="/config/delete/id/<?php echo  $item['id']; ?>"><i
                    class="icon-remove-sign"></i></a>
                    </td>
                    <td>
                    <a href="/time/log/config/<?php echo $item->id; ?>"><i class="icon-calendar"></i></a>
                    <?php if (isset($times['configTotal'][$item->id])) echo '<a href="/time/viewdetail/config/'.$item->id.'">'.$times['configTotal'][$item->id].'&nbsp;hrs</a>'; ?> 
                    </td>
                    <td>
                        <?php echo $item->creator->firstname . ' ' . $item->creator->lastname . ' ' . $item->create_date; ?>
                    </td>

                </tr>
                <?php

            endforeach;
        endif;

        ?>

        </tbody>
    </table>

    <?php
}




$this->endWidget();


// ####################  PROCESSES ###############

$processes = Process::model()->findAll('project_id ='.$project->id.' and active = 1');





    $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => 'Processes',
        'headerIcon' => 'icon-briefcase',
        // when displaying a table, if we include bootstra-widget-table class
        // the table will be 0-padding to the box
        'htmlOptions' => array('class' => 'bootstrap-widget-table'),
        'headerButtons' => array(

            array(
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'success', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'label' => 'Add Process  +',

                'url' => UrlHelper::getPrefixLink('/process/create/'),
            ),


        )
    ));

    if (!empty($processes)) {
?>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>


        </tr>
        </thead>
        <tbody>
        <?php if (count($processes)):

             foreach ($processes as $itemIdx => $item):

          
                ?>


                <tr class="odd">
                    <td>
                        <a href="<?php echo UrlHelper::getPrefixLink('/process/view/id/'.$item->ext) ?>"><?php echo $item['name']; ?></a>
                        - <?php echo $item['description']; 
                        
                        $lastrun = strtotime (Process::lastRun($item->id));
                        $interval = time()-$lastrun;
                                           
                        
                        ?>

                    


                    </td>
                    <td>
                    <a href="/process/delete/ext/<?php echo  $item['ext']; ?>"><i
                    class="icon-remove-sign"></i></a>
<?php /*
echo '<br/>last run '.date( "m/d/Y", strtotime($lastrun));
echo '<br/> frequency '.$item->frequency/(24*60*60).' days ';
echo '<br/> time since last run '.$interval/(24*60*60).' days <br/>';
echo 'last run value is '.$lastrun;
*/
                    if($item->frequency>0){
                        
                       if ($interval > $item->frequency){
                          $days = floor(($item->frequency-(time()-$lastrun))/(24*60*60))*-1;
                        
                      echo  '<i class="icon-time text-error"></i> ';
                      echo $days.' days overdue'; 
                        } 
                       ELSE
                        {
                         echo   '<i class="icon-time text-success"></i> ';
                         echo floor(($item->frequency-$interval)/(24*60*60)).' days'; 
                        }
                    }

?>
                    </td>

                </tr>
                <?php
           
            endforeach ?>


        <?php endif; ?>


        </tbody>
    </table>


    <?php
    }
        $this->endWidget();




// ####################  SYSTEMS ##################

$data = $project->systems;
//echo '<pre>';
//print_r($data);




    $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => 'Systems',
        'headerIcon' => 'icon-briefcase',
        // when displaying a table, if we include bootstra-widget-table class
        // the table will be 0-padding to the box
        'htmlOptions' => array('class' => 'bootstrap-widget-table'),
        'headerButtons' => array(

            array(
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'success', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'label' => 'Add System  +',

                'url' => UrlHelper::getPrefixLink('/system/create/'),
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
            
            
            


            <?php 
            
            //sort the systems into groups
            foreach ($data as $item) {
            //index the systems by their id    
                $systems[$item->id]=$item;
            // create an index of arrays of groups with item id's in their groups.
                if ($item->parent_id == -1) {
                        $groups[$item->id]=(!isset($groups[$item->id]))?array():$groups[$item->id];
                      // array_push($groups[$item->id],$item->id);
                } else {
                    $groups[$item->parent_id]=(!isset($groups[$item->parent_id]))?array():$groups[$item->parent_id];
                    array_push($groups[$item->parent_id],$item->id);
                }
            
            
            }


               foreach ($groups as $key=>$group) {
                   $item=$systems[$key];

                   $link = Projectsystem::model()->find('system_id = ' . $item['id'] . ' and project_id = ' . Yii::App()->session['project'] . ' order by id desc');
                   if ($item->deleted == 0 && $link->deleted == 0)

                   echo $this->renderPartial('_system', array('item'=>$item));



                   foreach ($group as $member) {
                       $item=$systems[$member];

                       $link = Projectsystem::model()->find('system_id = ' . $item['id'] . ' and project_id = ' . Yii::App()->session['project'] . ' order by id desc');
                       if ($item->deleted == 0 && $link->deleted == 0)
                           echo $this->renderPartial('_subsystem', array('item'=>$item));






                   }
               }
               ?>


        <?php endif; ?>


        </tbody>
    </table>

    <?php
    }
        $this->endWidget();


?>