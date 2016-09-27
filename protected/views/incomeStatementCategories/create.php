<?php
$this->breadcrumbs = array(
	'Category'=>array('index'),
	'Create',
);

Yii::app()->clientScript->registerScript('label', "
$('.label-button').click(function(){
	$('.label-form').toggle();
	return false;
});
");
?>


<h1>Add IS Sub-Account for <b>
<?php 
 	if($_GET['t']==0){	//if label
 		$criteria = new CDbCriteria;
 		$criteria->condition = "label_id={$_GET['p']}";
		$data = Label::model()->find($criteria)->getAttributes();
		echo $data['label_name'];
 	}else{
 		echo Account::model()->findByPk($_GET['p'])->getAttributes('acct_title');
 	}
 ?>
	</b>
</h1>

<?php echo CHtml::link('Add label','#',array('class'=>'label-button')); ?>
<div class="label-form" style="display:none">
	<!-- search-form -->
	<?php
	$this->widget('zii.widgets.jui.CJuiTabs',array(
	    'tabs'=>array(
			 'Create a new label' => array('id'=>'create_label_form_id',
			 		'content'=>$this->renderPartial(
			 			'_create_label_form',
			 			array('model'=>$model,'to_update'=>false),
			 			TRUE
	                    )
			 		),        
	    ),
	    // additional javascript options for the tabs plugin
	    'options'=>array(
	        'collapsible'=>true,'width'=>'100%'
	    ),
	    'id'=>'IS_create_tab',
	));
	?>
</div>
<br/>
<br/>
<?php echo $this->renderPartial('_create_form', array('model'=>$model,'acct_model'=>$acct_model)); ?>
