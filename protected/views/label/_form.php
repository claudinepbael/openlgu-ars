<?php
/* @var $this LabelController */
/* @var $model Label */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'label-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'label_name'); ?>
		<?php echo $form->textArea($model,'label_name',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'label_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'report'); ?>
		<?php echo $form->textField($model,'report'); ?>
		<?php echo $form->error($model,'report'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->