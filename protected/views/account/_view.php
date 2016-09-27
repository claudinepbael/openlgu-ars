<?php
/* @var $this AccountController */
/* @var $data Account */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('acct_code')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->acct_code), array('view', 'id'=>$data->acct_code)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acct_title')); ?>:</b>
	<?php echo CHtml::encode($data->acct_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('normal_balance')); ?>:</b>
	<?php echo CHtml::encode($data->normal_balance); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acct_description')); ?>:</b>
	<?php echo CHtml::encode($data->acct_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('report_classification')); ?>:</b>
	<?php echo CHtml::encode($data->report_classification); ?>
	<br />


</div>