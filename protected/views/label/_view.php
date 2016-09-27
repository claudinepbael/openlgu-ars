<?php
/* @var $this LabelController */
/* @var $data Label */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('label_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->label_id), array('view', 'id'=>$data->label_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('label_name')); ?>:</b>
	<?php echo CHtml::encode($data->label_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('report')); ?>:</b>
	<?php echo CHtml::encode($data->report); ?>
	<br />


</div>