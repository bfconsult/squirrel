<?php 
echo $this->renderPartial('/project/head',array('tab'=>'interfaces')); 

 $edit=(Yii::App()->session['edit']==1)?TRUE:FALSE;
    ?>
<h3>Create Interface</h3>

<?php 
if($edit) $this->renderPartial('_form', array('model'=>$model)); 
?>