<?php
/* @var $this JournalController */
/* @var $model Journal */

$this->breadcrumbs=array(
	'Journals'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Journal', 'url'=>array('index')),
	array('label'=>'Manage Journal', 'url'=>array('admin')),
);
?>

<h1>Create Journal</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<?php 
/*Yii::app()->clientScript->registerScript('textFieldAdder','$("#additional-link").bind("click",function(){
    var id="optional_text";
    var size=$("#additional-inputs > li input").size();
    $("#additional-inputs").append("<li><input type=text id="+id+size+" name="+id+"["+size+"]></li>");
    })')*/
?>

<?php /*$form = $this->beginWidget('CActiveForm', array(
    'id'=>'user-form',
    'enableAjaxValidation'=>true,
));*/ ?>
<?php //echo CHtml::link('Add input','#',array('id'=>'additional-link')); ?>
<?php //echo CHtml::submitButton('Submit');?>
<?php //$this->endWidget('CActiveForm');?>