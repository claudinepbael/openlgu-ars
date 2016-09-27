<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'label-form',
	'enableAjaxValidation'=>false,
)); 
		
	if (!$to_update){
		$model = new Label();
		$is_model = new IncomeStatementCategories();
	}
?>

	<p>
		<span><b> Create a new label and then add as a sub-account </b></span>
	</p>
	<p class="note" style="font-size:10px">
		Fields with <span class="required">*</span> are required.
	</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'label_name'); ?>
		<?php echo $form->textField($model,'label_name'); ?>
		<?php echo $form->error($model,'label_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($is_model,'amt_type'); ?>
		<?php echo $form->dropDownList($is_model,'amt_type',
			array('-1' => 'None',
			 '1'=>'Total amount of co-sub-accounts',
			 '2'=>'Total amount of sub-accounts',
			 )); ?>
		<?php echo $form->error($is_model,'amt_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($is_model,'is_added'); ?>
		<?php echo $form->dropDownList($is_model,'is_added',
			array(	'0' => 'Add',
			 		'1'=>'Less',
		)); ?>
		<?php echo $form->error($is_model,'is_added'); ?>
	</div>

	<?php 
		if ($to_update){
			echo $form->hiddenField($model,'label_pk',
				array('value'=>$model->l_pk)
			);
		}
		echo $form->hiddenField($model,'report',array('value'=>1));
	 	echo $form->hiddenField($is_model,'parent_id',array('value'=>$_GET['p']));
	 	echo $form->hiddenField($is_model,'type',array('value'=>0));
	?>	


	<div class="row buttons">
	<?php 
		if(!$to_update){
			echo CHtml::ajaxSubmitButton('Add', 
	         CHtml::normalizeUrl(array('IncomeStatementCategories/createWithLabel')), 
	         array(
	              'data'=>'js:jQuery(this).parents("form").serialize()+
	                             "&request=added"',       
	              'success'   => 'function(data) {
                		top.location.href="'.Yii::app()->createUrl('IncomeStatementCategories/index').'"; 
            		}'
	          ), 
	         array(
	              'id'=>'ajaxSubmitBtn', 
	              'name'=>'ajaxSubmitBtn'
	         )); 
		}else{
			echo CHtml::ajaxSubmitButton('Save', 
	         CHtml::normalizeUrl(
	         	array('IncomeStatementCategories/updateLabel')), 
	         	array(
	              'data'=>'js:jQuery(this).parents("form").serialize()+
	                             "&request=added"',       
	              'success'   => ''
	         	 ), 
	         	array(
	              'id'=>'ajaxSubmitBtn', 
	              'name'=>'ajaxSubmitBtn'
	         	)
	         ); 
		}
	?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->