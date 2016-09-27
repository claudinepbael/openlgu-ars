<?php
/* @var $this LedgerController */
/* @var $data Ledger */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jev')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jev), array('view', 'id'=>$data->jev)); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('particulars')); ?>:</b>
	<?php echo CHtml::encode($data->particulars); ?>
	<br />


</div>