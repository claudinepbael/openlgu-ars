<?php
/* @var $this JournalController */
/* @var $data Journal */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('j_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->j_id), array('view', 'id'=>$data->j_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acct_code')); ?>:</b>
	<?php echo CHtml::encode($data->acct_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('debit')); ?>:</b>
	<?php echo CHtml::encode($data->debit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('credit')); ?>:</b>
	<?php echo CHtml::encode($data->credit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_adjustment')); ?>:</b>
	<?php echo CHtml::encode($data->is_adjustment); ?>
	<br />


</div>