<?php
/* @var $this JournalController */
/* @var $model Journal */
/* @var $form CActiveForm */
?>
<!-- Jornal Form -->

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'journal-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'Transaction Date'); ?>
		<?php echo $form->dateField($model,'date'); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>


	<div class="row">
	</div>

	<?php
		$list = CHtml::ListData(Account::model()->findAll(),'acct_code','acct_title'); 
		//$bs_model=new BalanceSheetCategories;
	?>

	<div class="row">
		<?php echo $form->labelEx($model,'Account Code'); ?> 
		<?php echo $form->textField($model,'acct_code'); ?> 
		<?php /*echo $form->dropDownList(
						$model,
						'acct_code',
						$list, 
						array()
				);*/
		?>
		<?php echo $form->error($model,'acct_code'); ?> 
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
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'is_adjustment'); ?>
		<?php echo $form->labelEx($model,'Adjustment Entry'); ?>
		<?php echo $form->error($model,'is_adjustment'); ?>
	</div>


	<div></div>
	<div>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
		


<?php $this->endWidget(); ?>

</div>
<!--End of Journal form -->