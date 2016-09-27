<?php
/* @var $this JournalController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Journal Entries',
);

$this->menu=array(
	array('label'=>'Create Journal', 'url'=>array('create')),
	array('label'=>'Manage Journal', 'url'=>array('admin')),
);
?>

<h1>Journals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<?php 
/*$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'journal-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'j_id',
		'acct_code',
		'date',
		'debit',
		'credit',
		'description',
		/*
		'is_adjustment',
		
		array(
			'class'=>'CButtonColumn',
		),
	),
)); */?>
