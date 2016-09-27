<?php
/* @var $this AccountantController */
/* @var $model LGUAccountant */

$this->breadcrumbs=array(
	'Lguaccountants'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LGUAccountant', 'url'=>array('index')),
	array('label'=>'Manage LGUAccountant', 'url'=>array('admin')),
);
?>

<h1>Create LGUAccountant</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>