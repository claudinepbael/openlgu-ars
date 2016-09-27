<?php
/* @var $this JournalController */
/* @var $model Journal */

$this->breadcrumbs=array(
	'Journals'=>array('index'),
	$model->j_id=>array('view','id'=>$model->j_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Journal', 'url'=>array('index')),
	array('label'=>'Create Journal', 'url'=>array('create')),
	array('label'=>'View Journal', 'url'=>array('view', 'id'=>$model->j_id)),
	array('label'=>'Manage Journal', 'url'=>array('admin')),
);
?>

<h1>Update Journal <?php echo $model->j_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>