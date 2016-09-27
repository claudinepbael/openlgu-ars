<?php
$this->breadcrumbs=array(
	'Category'=>array('index'),
	'Create',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
");
?>

 
<h1>Add Sub-Account for <b>
	
<?php 
 	if($_GET['t']==0){	//if label
 		$criteria=new CDbCriteria;
 		$criteria->condition="label_id={$_GET['p']}";
		$data=Label::model()->find($criteria)->getAttributes();
		echo $data['label_name'];
 	}else{
 		echo Account::model()->findByPk($_GET['p'])->getAttributes('acct_title');
 	}
?>
	</b>
</h1>

<?php echo CHtml::link('Add label','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
	<!-- search-form -->

<?php
$this->widget('zii.widgets.jui.CJuiTabs',array(
    'tabs'=>array(
        //'StaticTab '=>'Content for tab 1',
        //'StaticTab With ID'=>array('content'=>'Content for tab 2 With Id' , 'id'=>'tab2'),
        /*'Add existing account'=>array('id'=>'create-form-id',
        		'content'=>$this->renderPartial(
                   '_create_form',
                    array('model'=>$model,'acct_model'=>$acct_model),TRUE
                )),*/
	     /*'Add existing label'=>array('id'=>'create-form-id',
	     		'content'=>$this->renderPartial(
	    			'_create_form_label',
	    			array('model'=>$model,),TRUE
	    		)),*/ 
		 'Create a new label'=>array('id'=>'create_label_form-id',
		 		'content'=>$this->renderPartial(
		 			'_create_label_form',
		 			array('model'=>$model),
		 			TRUE
                    )
		 		),        
        // panel 3 contains the content rendered by a partial view
        //'AjaxTab'=>array('ajax'=>$this->createUrl('ajax')),
    ),
    // additional javascript options for the tabs plugin
    'options'=>array(
        'collapsible'=>true,'width'=>'100%'
    ),
    'id'=>'MyTab-Menu',
));
?>
<?php 
	//$this->renderPartial('_create_label_form',array(
	//	'model'=>$model,
	//)); 
?>
</div>
<br/>
<br/>
<?php echo $this->renderPartial('_create_form', array('model'=>$model,'acct_model'=>$acct_model)); ?>
