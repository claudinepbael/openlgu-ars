
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields WITH <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php
			//var_dump(BalanceSheetCategories::model()->findAll()->getAttributes());

		//ILIPAT SA CONTROLLER
		$criteria=new CDbCriteria;
	 	$criteria->condition="report=0";
		$list = CHtml::ListData(Label::model()->findAll($criteria),'label_id','label_name'); 
		$criteria=new CDbCriteria;
	 	$criteria->order="acct_code ASC";
		$list += CHtml::ListData(Account::model()->findAll($criteria),'acct_code','acct_title');

	?>

	<div class="row">
		<?php
			echo $form->labelEx($model,'parent_id');
			echo $form->dropDownList(
						$model,
						'parent_id', 
						$list, 
						array(
							'options'=>array(BalanceSheetCategories::model()->find("id={$_GET['p']}")->getAttribute('parent_id')=>array('selected'=>true,'readonly'=>true))
						)
				);
		?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id'); ?>
		<?php echo $form->dropDownList(
						$model,
						'id',
						$list, 
						array(
							'options'=>array($model->parent_id=>array('selected'=>true))
						)
			 	);
		?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'is_total_of_subcategories'); ?>
		<?php //echo $form->checkBox($model,'is_total_of_subcategories'); ?>
	</div>

	<div class="row nolabel buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
