<?php
/* @var $this LedgerController */
/* @var $data Ledger */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ldgr_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ldgr_id), array('view', 'id'=>$data->ldgr_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acct_no')); ?>:</b>
	<?php echo CHtml::encode($data->acct_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('t_date')); ?>:</b>
	<?php echo CHtml::encode($data->t_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('debit')); ?>:</b>
	<?php echo CHtml::encode($data->debit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('credit')); ?>:</b>
	<?php echo CHtml::encode($data->credit); ?>
	<br />


</div>