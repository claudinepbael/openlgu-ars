<?php
/* @var $this AccountController */
/* @var $model Account */

$this->breadcrumbs=array(
	'Accounts'=>array('index'),
	$model->acct_code=>array('view','id'=>$model->acct_code),
	'Update',
);

$this->menu=array(
	array('label'=>'List Account', 'url'=>array('index')),
	array('label'=>'Create Account', 'url'=>array('create')),
	array('label'=>'View Account', 'url'=>array('view', 'id'=>$model->acct_code)),
	array('label'=>'Manage Account', 'url'=>array('admin')),
);
?>

<h1>Update Account <?php echo $model->acct_code; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>