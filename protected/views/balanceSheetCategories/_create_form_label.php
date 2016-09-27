
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php

		//ILIPAT SA CONTROLLER
		$criteria=new CDbCriteria;
	 	$criteria->condition="report=0";
		$list = CHtml::ListData(Label::model()->findAll($criteria),'label_id','label_name'); 
		$bs_model=new BalanceSheetCategories;

	?>

	<div class="row">
		<?php echo $form->labelEx($model,'id'); ?>
		<?php echo $form->dropDownList(
						$bs_model,
						'id',
						$list, 
						array(
							'options'=>array($model->parent_id=>array('selected'=>true))
						)
				);
		?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($bs_model,'amt_type'); ?>
		<?php echo $form->dropDownList($bs_model,'amt_type',array('-1' => 'None',
			 '1'=>'Total amount of co-sub-accounts',
			 '2'=>'Total amount of sub-accounts' )); ?>
		<?php echo $form->error($bs_model,'amt_type'); ?>
	</div>

	<?php echo $form->hiddenField($model,'report',array('value'=>0));?>
	<?php echo $form->hiddenField($bs_model,'position',array('value'=>$_GET['p']));?>
	<?php echo $form->hiddenField($bs_model,'parent_id',array('value'=>$_GET['p']));?>
	<?php echo $form->hiddenField($bs_model,'type',array('value'=>0));?>	

	<div class="row nolabel buttons">
		<?php 
			echo CHtml::ajaxSubmitButton($model->isNewRecord ? 'Add' : 'Save', 
		         CHtml::normalizeUrl(array('BalanceSheetCategories/create')), 
		         array(
		              'data'=>'js:jQuery(this).parents("form").serialize()+
		                             "&request=added"',       
		              'success'   => 'function(data) {
                    		top.location.href="'.Yii::app()->createUrl('BalanceSheetCategories/index').'"; 
                		}'
		          ), 
		         array(
		              'id'=>'ajaxSubmitBtn1', 
		              'name'=>'ajaxSubmitBtn1'
		         )); 

		?>
	</div>


	<div class="row nolabel buttons">
		<?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
