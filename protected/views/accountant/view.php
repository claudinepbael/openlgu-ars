<?php
/* @var $this AccountantController */
/* @var $model LGUAccountant */

$this->breadcrumbs=array(
	'LGU Accountant'=>array('index'),
	$model->id,
);

$this->menu=array(
	/*array('label'=>'List LGUAccountant', 'url'=>array('index')),
	array('label'=>'Create LGUAccountant', 'url'=>array('create')),*/
	array('label'=>'Update Accountant Name', 'url'=>array('update', 'id'=>$model->accountant_name)),
	// array('label'=>'Delete LGUAccountant', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->accountant_name),'confirm'=>'Are you sure you want to delete this item?')),
	// array('label'=>'Manage LGUAccountant', 'url'=>array('admin')),
);
?>

<h1>LGU Accountant</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'accountant_name',
	),
)); ?>
