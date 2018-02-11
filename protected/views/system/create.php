<h1>Create a New System</h1>


<h2>Add an existing shared system</h2>

<?php

echo $this->renderPartial('_link', array('model'=>$model)); ?>


<h2>Add a custom system for this Project.</h2>
<?php 

echo $this->renderPartial('_form', array('model'=>$model)); ?>