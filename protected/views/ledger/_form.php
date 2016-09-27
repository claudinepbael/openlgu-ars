<?php
/* @var $this LedgerController */
/* @var $model Ledger */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ledger-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'acct_code'); ?>
		<?php echo $form->textField($model,'acct_code'); ?>
		<?php echo $form->error($model,'acct_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
		<?php echo $form->dateField($model,'date'); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'debit'); ?>
		<?php echo $form->textField($model,'debit'); ?>
		<?php echo $form->error($model,'debit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'credit'); ?>
		<?php echo $form->textField($model,'credit'); ?>
		<?php echo $form->error($model,'credit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'particulars'); ?>
		<?php echo $form->textArea($model,'particulars',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'particulars'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->