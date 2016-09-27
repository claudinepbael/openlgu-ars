<?php
/* @var $this LGUInfoController */
/* @var $model LGUInfo */

$this->breadcrumbs=array(
	'LGU Name'=>array('index'),
	$model->id,
);

$this->menu=array(
	/*array('label'=>'List LGUInfo', 'url'=>array('index')),
	array('label'=>'Create LGUInfo', 'url'=>array('create')),*/
	array('label'=>'Update LGU Name', 'url'=>array('update', 'id'=>$model->LGU_name)),
	/*array('label'=>'Delete LGUInfo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->LGU_name),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LGUInfo', 'url'=>array('admin')),*/
);
?>

<h1>LGU Name</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'LGU_name',
	),
)); ?>
