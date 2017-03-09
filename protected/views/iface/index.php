<h1>Batch Files <?php echo CHtml::link('<i class="icon-download" rel="tooltip" title="" data-original-title="download batch"></i>', array('/batch/download', 'id'=>$id)); ?></h1>
<table>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
</table>
