<?php
/* @var $this JournalController */
/* @var $model Journal */

$this->breadcrumbs=array(
	'Journals'=>array('index'),
	$model->j_id,
);

$this->menu=array(
	array('label'=>'List Journal', 'url'=>array('index')),
	array('label'=>'Create Journal', 'url'=>array('create')),
	array('label'=>'Update Journal', 'url'=>array('update', 'id'=>$model->j_id)),
	array('label'=>'Delete Journal', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->j_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Journal', 'url'=>array('admin')),
);
?>

<h1>View Journal #<?php echo $model->j_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'j_id',
		'acct_code',
		'date',
		'debit',
		'credit',
		'description',
		'is_adjustment',
	),
)); ?>
