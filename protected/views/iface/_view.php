<?php
/* @var $this RegionController */
/* @var $data Region */
?>
<tr>
<td><?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?></td>
<td><?php echo CHtml::encode($data->name); ?></td>
    <td><?php echo CHtml::encode($data->file); ?></td>
<td><?php echo CHtml::link('process', array('process', 'id'=>$data->id)); ?> <?php echo CHtml::link('View', array('view', 'id'=>$data->id)); ?></td>
</tr>