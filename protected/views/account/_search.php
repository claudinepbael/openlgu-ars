<?php
/* @var $this AccountController */
/* @var $model Account */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'acct_code'); ?>
		<?php echo $form->textField($model,'acct_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'acct_title'); ?>
		<?php echo $form->textArea($model,'acct_title',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'normal_balance'); ?>
		<?php echo $form->textField($model,'normal_balance',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'acct_description'); ?>
		<?php echo $form->textArea($model,'acct_description',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'report_classification'); ?>
		<?php echo $form->textField($model,'report_classification',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->