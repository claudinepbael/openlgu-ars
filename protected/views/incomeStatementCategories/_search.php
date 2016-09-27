<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'category_acct_code'); ?>
		<?php echo $form->textField($model,'category_acct_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'parent_category_acct_code'); ?>
		<?php echo $form->textField($model,'parent_category_acct_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'position'); ?>
		<?php echo $form->textField($model,'position'); ?>
	</div>

	<!--div class="row">
		<?php //echo $form->label($model,'slug'); ?>
		<?php //echo $form->textField($model,'slug',array('size'=>50,'maxlength'=>50)); ?>
	</div-->

	<div class="row">
		<?php echo $form->label($model,'category_acct_title'); ?>
		<?php echo $form->textField($model,'category_acct_title',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
