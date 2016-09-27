<?php
/* @var $this JournalController */
/* @var $model Journal */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'j_id'); ?>
		<?php echo $form->textField($model,'j_id'); ?>
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
		<?php echo $form->label($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_adjustment'); ?>
		<?php echo $form->textField($model,'is_adjustment'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->