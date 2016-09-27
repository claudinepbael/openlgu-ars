<?php
/* @var $this LabelController */
/* @var $model Label */

$this->breadcrumbs=array(
	'Labels'=>array('index'),
	$model->label_id=>array('view','id'=>$model->label_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Label', 'url'=>array('index')),
	array('label'=>'Create Label', 'url'=>array('create')),
	array('label'=>'View Label', 'url'=>array('view', 'id'=>$model->label_id)),
	array('label'=>'Manage Label', 'url'=>array('admin')),
);
?>

<h1>Update Label <?php echo $model->label_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>