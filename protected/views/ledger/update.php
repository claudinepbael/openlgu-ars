<?php
/* @var $this LedgerController */
/* @var $model Ledger */

$this->breadcrumbs=array(
	'Ledgers'=>array('index'),
	$model->jev=>array('view','id'=>$model->jev),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Ledger', 'url'=>array('index')),
	array('label'=>'Create Ledger', 'url'=>array('create')),
	array('label'=>'View Ledger', 'url'=>array('view', 'id'=>$model->jev)),
	array('label'=>'Manage Ledger', 'url'=>array('admin')),
);
?>

<h1>Update Ledger <?php echo $model->jev; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>