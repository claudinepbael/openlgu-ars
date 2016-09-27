<?php
/* @var $this LGUInfoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lguinfos',
);

$this->menu=array(
	array('label'=>'Create LGUInfo', 'url'=>array('create')),
	array('label'=>'Manage LGUInfo', 'url'=>array('admin')),
);
?>

<h1>Lguinfos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
