<?php
/* @var $this LabelController */
/* @var $model Label */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'label_id'); ?>
		<?php echo $form->textField($model,'label_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'label_name'); ?>
		<?php echo $form->textArea($model,'label_name',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'report'); ?>
		<?php echo $form->textField($model,'report'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->