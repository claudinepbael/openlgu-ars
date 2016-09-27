<?php
/* @var $this AccountController */
/* @var $model Account */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'account-form',
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
		<?php echo $form->labelEx($model,'acct_title'); ?>
		<?php echo $form->textArea($model,'acct_title',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'acct_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'normal_balance'); ?>
		<?php echo $form->textField($model,'normal_balance',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'normal_balance'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'acct_description'); ?>
		<?php echo $form->textArea($model,'acct_description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'acct_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'report_classification'); ?>
		<?php echo $form->dropDownList($model,'report_classification',array('Balance Sheet'=>'Balance Sheet','Income Statement'=>'Income Statement')); ?>
		<?php echo $form->error($model,'report_classification'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->