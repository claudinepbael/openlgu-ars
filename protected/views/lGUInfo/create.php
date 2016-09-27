<?php
/* @var $this LGUInfoController */
/* @var $model LGUInfo */

$this->breadcrumbs=array(
	'Lguinfos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LGUInfo', 'url'=>array('index')),
	array('label'=>'Manage LGUInfo', 'url'=>array('admin')),
);
?>

<h1>Create LGUInfo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>