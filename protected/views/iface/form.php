<fieldset>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'iface-form',
        'enableAjaxValidation' => false,
        //This is very important when uploading files
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>

    <!-- Other Fields... -->
    <div class="row">
        <?php echo $form->labelEx($model,'photos'); ?>
        <?php
        $this->widget( 'xupload.XUpload', array(
                'url' => Yii::app( )->createUrl( "/controller/upload"),
                //our XUploadForm
                'model' => $photos,
                //We set this for the widget to be able to target our own form
                'htmlOptions' => array('id'=>'iface-form'),
                'attribute' => 'file',
                'multiple' => true,
                //Note that we are using a custom view for our widget
                //Thats becase the default widget includes the 'form'
                //which we don't want here
                'formView' => 'application.views.iface._form',
            )
        );
        ?>
    </div>
    <button type="submit">Submit</button>
    <?php $this->endWidget(); ?>
</fieldset>