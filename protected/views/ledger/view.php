<?php
/* @var $this LedgerController */
/* @var $model Ledger */

$this->breadcrumbs=array(
	'Ledgers'=>array('index'),
	$model->jev,
);

$this->menu=array(
	//array('label'=>'List Ledger', 'url'=>array('index')),
	array('label'=>'Create Ledger', 'url'=>array('create')),
	array('label'=>'Update Ledger', 'url'=>array('update', 'id'=>$model->jev)),
	array('label'=>'Delete Ledger', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->jev),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Ledger', 'url'=>array('admin')),
);
?>

<h1>View JEV #<?php echo $model->jev; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'jev',
		'acct_code',
		'date',
		'debit',
		'credit',
		'particulars',
	),
)); ?>
