<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'label-form',
	'enableAjaxValidation'=>false,
)); 
	
	$model = new Label();
	$bs_model = new BalanceSheetCategories();
?>

	<p>
		<span><b> Create a new label and then add as a sub-account </b></span>
	</p>
	<p class="note" style="font-size:10px">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'label_name'); ?>
		<?php echo $form->textField($model,'label_name'); ?>
		<?php echo $form->error($model,'label_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($bs_model,'amt_type'); ?>
		<?php echo $form->dropDownList($bs_model,'amt_type',array('-1' => 'None',
			 '1'=>'Total amount of co-sub-accounts',
			 '2'=>'Total amount of sub-accounts',
			 '3'=>'Less to co-sub-accounts' )); ?>
		<?php echo $form->error($bs_model,'amt_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($bs_model,'is_added'); ?>
		<?php echo $form->dropDownList($bs_model,'is_added',array('0' => 'Add',
			 '1'=>'Less',
		)); ?>
		<?php echo $form->error($bs_model,'is_added'); ?>
	</div>

	<?php echo $form->hiddenField($model,'report',array('value'=>0));?>
	<?php echo $form->hiddenField($bs_model,'parent_id',array('value'=>$_GET['p']));?>
	<?php echo $form->hiddenField($bs_model,'type',array('value'=>0));?>	


	<div class="row buttons">
		<?php 
			echo CHtml::ajaxSubmitButton($model->isNewRecord ? 'Add' : 'Save', 
		         CHtml::normalizeUrl(array('BalanceSheetCategories/createWithLabel')), 
		         array(
		              'data'=>'js:jQuery(this).parents("form").serialize()+
		                             "&request=added"',       
		               'success'   => 'function(data) {
                   			top.location.href="'.Yii::app()->createUrl('BalanceSheetCategories/index').'"; 
                 		}'
		          ), 
		         array(
		              'id'=>'ajaxSubmitBtn', 
		              'name'=>'ajaxSubmitBtn'
		         )); 

		?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->