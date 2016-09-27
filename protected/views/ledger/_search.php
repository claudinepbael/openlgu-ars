<?php
/* @var $this LedgerController */
/* @var $model Ledger */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'jev'); ?>
		<?php echo $form->textField($model,'jev'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'acct_code'); ?>
		<?php echo $form->textField($model,'acct_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date'); ?>
		<?php echo $form->textField($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'debit'); ?>
		<?php echo $form->textField($model,'debit'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'credit'); ?>
		<?php echo $form->textField($model,'credit'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'particulars'); ?>
		<?php echo $form->textArea($model,'particulars',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->