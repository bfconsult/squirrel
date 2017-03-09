

<?php 

$data = User::model()->companyUsers();
$admin = Company::model()->Admins(); 
$me = User::model()->findbyPK(Yii::app()->user->id);
$lang=Yii::App()->session['lang'];


$terms=Company::model()->metaLoad('terms'.$lang,Yii::App()->params['terms']);
$vocab=Yii::App()->params['vocab'][$lang];
$terms=$terms+Yii::App()->params['terms'][$lang];
$vocab=$vocab+Yii::App()->params['vocab']['en'];
$terms=$terms+Yii::App()->params['terms']['en']+$vocab;

foreach($terms as $term=>$word){// PUT FIXED TERMS INTO PARAMETER
    Yii::App()->params[$term]=$word;
}
?>

<div class="well">
    <h1><?php echo $model->name; ?></h1>
     <?php    if($me->admin==1) {?>
    <a href="<?php echo UrlHelper::getPrefixLink('/company/update?id=')?><?php echo $model->id; ?>">
        <i class="icon-cog"></i></a>
 <?php 
     }
echo $model->description;
?>
 
   
</div>



<?php 
$tab=Yii::App()->session['setting_tab'];
if (!isset($tab)) $tab='employees';


 
// if this company project owner is current viewer
  
    $edit=(Yii::App()->session['edit']==1)?TRUE:FALSE;
    $permission=Yii::App()->session['permission'];
    $phase=Yii::App()->session['phase'];
    $totalstages=0;
    $status = array('invited','confirmed');

?>



<!-- make tab -->
<?php $tabs = array()?>

<!-- Setup condition -->
<?php 
$active = array();
$active['details'] = FALSE;
$active['contacts'] = FALSE;
$active['output'] = FALSE;
$active['employees'] = FALSE;
$active['scores'] = FALSE;
$active['timezone'] = FALSE;
$active['language'] = FALSE;

 $active[$tab]=TRUE;

       $tabs[] = array('id' => 'employees', 
        'label' => Yii::App()->params['people'],
        //'visible' => in_array($permission,array(1,2,3,4,5)),
        'content' => $this->renderPartial('_employees',
                compact('model'),true,false),'active'=>$active['employees']);
    $tabs[] = array('id' => 'details',
            'label' => Yii::App()->params['companydetails'],
           // 'visible' => in_array($permission,array(1,2,3,4,5)),
            'content' => $this->renderPartial('_details',
                    compact('model'),true,false),'active'=>$active['details']);

    $tabs[] = array('id' => 'contacts',
    'label' => Yii::App()->params['contacts'],
    // 'visible' => in_array($permission,array(1,2,3,4,5)),
    'content' => $this->renderPartial('mycompanies',
        compact('model'),true,false),'active'=>$active['contacts']);

    $tabs[] = array('id' => 'scores', 
        'label' => Yii::App()->params['scores'],
       // 'visible' => in_array($permission,array(1,2,3,4,5)),
        'content' => $this->renderPartial('_scores',
                compact('model'),true,false),'active'=>$active['scores']);

    $tabs[] = array('id' => 'output', 
        'label' => Yii::App()->params['output'],
       // 'visible' => in_array($permission,array(1,2,3,4,5)),
        'content' => $this->renderPartial('_output',
                compact('model'),true,false),'active'=>$active['output']);

    $tabs[] = array('id' => 'timezone',
        'label' => Yii::App()->params['timezone'],
       // 'visible' => in_array($permission,array(1,2,3,4,5)),
        'content' => $this->renderPartial('_timezone',
                compact('model'),true,false),'active'=>$active['timezone']);
$tabs[] = array('id' => 'language',
    'label' => Yii::App()->params['language'],
    // 'visible' => in_array($permission,array(1,2,3,4,5)),
    'content' => $this->renderPartial('_language',
        compact('model'),true,false),'active'=>$active['language']);

   /* $tabs[] = array('id' => 'sizing', 
        'label' => 'Output',
       // 'visible' => in_array($permission,array(1,2,3,4,5)),
        'content' => $this->renderPartial('_output',
                compact('model'),true,false),'active'=>$active['output']); */
 
?>
<?php  $this->widget('bootstrap.widgets.TbTabs', array(
    'id' => 'mytabs',
    'type' => 'tabs',
    'tabs' => $tabs,
    //'events'=>array('shown'=>'js:loadContent')
)); ?>

