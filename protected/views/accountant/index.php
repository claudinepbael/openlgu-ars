<?php
/* @var $this AccountantController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lguaccountants',
);

$this->menu=array(
	array('label'=>'Create LGUAccountant', 'url'=>array('create')),
	array('label'=>'Manage LGUAccountant', 'url'=>array('admin')),
);
?>

<h1>Lguaccountants</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
