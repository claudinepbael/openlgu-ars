<?php
/* @var $this AccountController */
/* @var $model Account */

$this->breadcrumbs=array(
	'Accounts'=>array('index'),
	$model->acct_code,
);

$this->menu=array(
	array('label'=>'List Account', 'url'=>array('index')),
	array('label'=>'Create Account', 'url'=>array('create')),
	array('label'=>'Update Account', 'url'=>array('update', 'id'=>$model->acct_code)),
	array('label'=>'Delete Account', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->acct_code),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Account', 'url'=>array('admin')),
);
?>

<h1>View Account #<?php echo $model->acct_code; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'acct_code',
		'acct_title',
		'normal_balance',
		'acct_description',
		'report_classification',
	),
)); ?>
