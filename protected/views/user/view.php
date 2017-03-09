<?php
$limit=50;

$data = User::model()->findAll(array('order'=>'id DESC','limit' => $limit));

        if (count($data)):

$box = $this->beginWidget('bootstrap.widgets.TbBox', array(
	'title' => 'Users',
	'headerIcon' => 'icon-person',
	// when displaying a table, if we include bootstra-widget-table class
	// the table will be 0-padding to the box
	'htmlOptions' => array('class'=>'bootstrap-widget-table')
));
            $moods = User::model()->overallMood();
           // print_r($moods);die;
            //$moods = json_decode($moods, true);
            $moodScore=0;
            $count=0;
            //echo $moods; die;
            foreach ($moods as $mood){
                if (isset ($mood['meta_value'])) $value=$mood['meta_value'];
                $value = json_decode($value, true);
              //  print_r($value);//echo 'values is: '.$value;

                $thisScore = (isset($value['id'])) ?$value['id']: 0 ;

                $moodScore=$moodScore+$thisScore;
                $count++;
//echo 'meta_value is :'.$mood['meta_value'].'<br />';
            }
            $score=round($moodScore/$count,0);
            if($score==0) $score=1;
           echo 'Total Scores: '.$count.' result '. User::$mood_name[$score];

            ?>


<table class="table">
	<thead>
	<tr>
        <th>User</th>
        <th>Active</th>
	<th>Company(Projects)</th>
	<th>Actions</th>
	</tr>
	</thead>
        <tbody>

        <?php foreach($data as $item) {?>
        <tr class="odd"> 
   
        <td>   
        <a href="<?php echo UrlHelper::getPrefixLink('/user/detail?id=')?><?php echo $item['id'];?>">
        <?php echo $item->firstname.' '.$item->lastname;?>(id <?php echo $item['id'];?>)
        </a>
        </td>
        
        <td>
            <?php echo $item->email;?>
        </td> 
 
    
        
        <td>
        <a href="<?php echo UrlHelper::getPrefixLink('/company/view?id=')?><?php echo $item->company_id;?>">
            <?php if(isset($item->company->name)){
                echo $item->company->name;?>
               </a>
             (
        Projects:   <?php  echo count(Project::model()->findAll('company_id='.$item->company->id)); ?>
           - Changes: <?php  echo Version::model()->companyChanges($item->company->id); ?>

                    ) 
            <?php

            $mood = User::model()->adminMeta($item->company->id,$item->id,'mood');
            //echo $mood;
            echo User::$mood_name[$mood];
            }
            ?>


        </td>  
        
        <td>
         <a href="<?php echo UrlHelper::getPrefixLink('/user/actup?id=')?><?php echo $item['id'];?>"><i class="icon-user" rel="tooltip" title="Act as this User"></i></a> 
       
            <?php
       echo CHtml::link(
    '<i class="icon-trash" rel="tooltip" title="Remove this User and all their assets"></i>',
     UrlHelper::getPrefixLink('/user/destroy/?id='.$item['id']),
     array('confirm' => 'This will permanently delete this user, there is NO undo.  Are you sure?')
);
    ?>
         </i></a> 
       
            
            </td>
        </tr>
       <?php }?>
                <tr><td>
          
            </td></tr>
        
   	</tbody>
</table>

<?php




$this->endWidget();
endif;



?>

