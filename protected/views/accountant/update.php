<?php
/* @var $this AccountantController */
/* @var $model LGUAccountant */

$this->breadcrumbs=array(
	'LGU Accountant'=>array('index'),
	$model->accountant_name=>array('view','id'=>$model->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List LGUAccountant', 'url'=>array('index')),
	array('label'=>'Create LGUAccountant', 'url'=>array('create')),
	array('label'=>'View LGUAccountant', 'url'=>array('view', 'id'=>$model->accountant_name)),
	array('label'=>'Manage LGUAccountant', 'url'=>array('admin')),
);*/
?>

<h2>Update Name of Accountant <?php echo $model->accountant_name; ?></h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>