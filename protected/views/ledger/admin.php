<?php
/* @var $this LedgerController */
/* @var $model Ledger */

$this->breadcrumbs=array(
	'Ledgers'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Ledger', 'url'=>array('index')),
	array('label'=>'Create Ledger', 'url'=>array('create')),
);

/*Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#ledger-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");*/

Yii::app()->clientScript->registerScript('create', "
$('.create-ledger').click(function(){
	$('.create-ledger-form').toggle();
	return false;
});");
?>

<h1>Manage Ledgers</h1>

<?php echo CHtml::link('Add an entry to the ledger','#',array('class'=>'create-ledger')); ?>
<div class="create-ledger-form" style="display:none">
<?php $this->renderPartial('_form',array(
	'model'=>$model,
)); ?>
</div><!-- create-form -->


<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ledger-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'jev',
		'acct_code',
		array(
          //'name'=>'acct_title',
          'header'=>'Account Title','type'=>'html',
          'value'=>'Account::model()->findByPk($data[\'acct_code\'])->getAttribute(\'acct_title\')',
        ),
		'date',
		array(
	        'header'=>'Debit',
	        'value'=>'$data->debit>0?Yii::app()->format->number($data->debit):" "',
	        'htmlOptions'=>array('style' => 'text-align: right;'),
      	),
		 array(
	        'header'=>'Credit',
	        'value'=>'$data->credit>0?Yii::app()->format->number($data->credit):" "',
	        'htmlOptions'=>array('style' => 'text-align: right;'),
      	),
		'particulars',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
