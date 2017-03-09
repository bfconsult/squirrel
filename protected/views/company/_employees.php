
    

<?php 

$data = User::model()->companyUsers();
$admin = Company::model()->Admins(); 
$me = User::model()->findbyPK(Yii::app()->user->id);





/*
if(!(Users_meta::model()->ShowMessage('employee1')))
    {
    $employee1=  'This list shows all the people in your company '.CHtml::ajaxLink(
    'OK, Got it',
    array('/users_meta/seen', 'message' => 'employee1'), // Yii URL
    array('update' => 'aoeu') // jQuery selector
    );
    
  $this->widget('ext.tooltipster.tooltipster',
        
         array('options'=>array(
            'interactive'=>TRUE,
             'content'=>$employee1,
            
             'offsetX'=>-300,
             'offsetY'=>-50,
             'maxWidth'=>120,
            'autoClose'=>FALSE,)));  
    
    
    }

  */


 if (count($data)):?>


<?php $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
	'title' => Yii::App()->params['companyusers'],
	'headerIcon' => 'icon-user',
	// when displaying a table, if we include bootstra-widget-table class
	// the table will be 0-padding to the box
	'htmlOptions' => array('class'=>'bootstrap-widget-table'),
     'headerButtons' => array(
    array(
        'class' => 'bootstrap.widgets.TbButton',
        'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'label'=> 'Invite User',
        'visible'=>$me->admin==1,
        'url'=>UrlHelper::getPrefixLink('/user/invite'),
      
    )),
));


?>



<table class="table tooltipster" >
    <thead >
	<tr>
		<th><?php echo Yii::App()->params['type']; ?></th>
		<th><?php echo Yii::App()->params['name']; ?></th>
		<th><?php echo Yii::App()->params['email']; ?></th>
		<th><?php echo Yii::App()->params['actions']; ?></th>
	
	</tr>
	</thead>
	
        <tbody>
            
         
        <?php foreach($data as $item) {?>
        <tr class="odd">  
            <td>
                 <?php if($item['admin']==1) { ?> 
                <i class="icon-user" rel="tooltip" title="Administrator"></i>
                
                 <?php } ?>
            </td>
         <td>   
        <?php echo $item['firstname']." ".$item['lastname'];?>
            </td>
            <td>
            <?php echo $item['email'];?>
      </td>
            <td>
               
                 <?php    if($me->id==$item['id'] && $me->admin!=1) {?>
                 <a href="<?php echo UrlHelper::getPrefixLink('/user/view/id/')?><?php echo $item['id'];?>"><i class="icon-eye-open" rel="tooltip" title="View"></i></a> 
    
                    <?php }?>
                <?php    if($me->admin==1) {?>
                  <?php    if($item['type']==0) {?>
                <a href="<?php echo UrlHelper::getPrefixLink('/user/reinvite/id/')?><?php echo $item['id'];?>"><i class="icon-envelope" rel="tooltip" title="Resend Invitation Email"></i></a> 
                <?php }?>
  <a href="<?php echo UrlHelper::getPrefixLink('/user/view/id/')?><?php echo $item['id'];?>"><i class="icon-eye-open" rel="tooltip" title="View"></i></a> 
    
                            <?php if($item['admin']==1 && count($admin)>1) {?>
                             <a href="<?php echo UrlHelper::getPrefixLink('/user/demote/id/')?><?php echo $item['id'];?>"><i class="icon-circle-arrow-down" rel="tooltip" title="Remove Administrator Rights"></i> </a>
                            <?php }?>
                             <?php if($item['admin']!=1) {?>
                             <a href="<?php echo UrlHelper::getPrefixLink('/user/promote/id/')?><?php echo $item['id'];?>"><i class="icon-circle-arrow-up" rel="tooltip" title="Promote to Administrator"></i> </a>
                           
                             <a href="<?php echo UrlHelper::getPrefixLink('/user/sack/id/')?><?php echo $item['id'];?>"><i class="icon-remove-sign" rel="tooltip" title="Remove user from company"></i></a> 
              <?php }?>
               <?php }?>
 
            </td>
        </tr>
       <?php } ?>
                </tbody>
</table>

 <?php 
 
 $this->endWidget(); 
endif;	


 

