<?php
/* @var $this LGUInfoController */
/* @var $model LGUInfo */

$this->breadcrumbs=array(
	'LGU Name'=>array('index'),
	$model->LGU_name=>array('view','id'=>$model->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List LGUInfo', 'url'=>array('index')),
	array('label'=>'Create LGUInfo', 'url'=>array('create')),
	array('label'=>'View LGUInfo', 'url'=>array('view', 'id'=>$model->LGU_name)),
	array('label'=>'Manage LGUInfo', 'url'=>array('admin')),
);
*/?>

<h1>Update Name of <?php echo $model->LGU_name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>