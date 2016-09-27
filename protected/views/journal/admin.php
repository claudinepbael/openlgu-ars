<?php
/* @var $this JournalController */
/* @var $model Journal */

$this->breadcrumbs=array(
	'Journals'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Journal', 'url'=>array('index')),
	array('label'=>'Create Journal', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#journal-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Journals</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
	$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'journal-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'j_id',
		'acct_code',
    array(
          //'name'=>'acct_title',
          'header'=>'Account Title','type'=>'html',
          'value'=>'Account::model()->findByPk($data[\'acct_code\'])->getAttribute(\'acct_title\')',
        ),
		'date',
    array(
        'header'=>'Debit',
        'value'=>'Yii::app()->format->number($data->debit)',
      ),
		'debit',
		'credit',
		'description',
		'is_adjustment',
		
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 
?>

<?php 

/*echo CHtml::beginForm();

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$model->search(),
    'columns'=>array(
      array(
        'class'=>'CLinkColumn',
        'header'=>'Journal Id',
        'labelExpression'=>'$data->j_id',
        'urlExpression'=>'Yii::app()->createUrl("journal/$data->j_id")',
        'htmlOptions'=>array('text-align'=>'center')
      ),
     array( //TextBox --- Displays quantity
        'header'=>'Transaction Date',
        'value'=>'$data->date',
        'type'=>'raw',
        'htmlOptions'=>array('width'=>'40px'),
      ),array( //TextBox --- Displays quantity
        'header'=>'Credit',
        'value'=>'CHTML::activeNumberField($data,\'credit\')',
        'type'=>'raw',
        'htmlOptions'=>array('width'=>'40px',),
        //'htmlOptions'=>array('width'=>'40px'),
      ),array( //TextBox --- Displays quantity
        'header'=>'JJournal IDDDD',
        'value'=>'CHTML::activeNumberField($data,\'j_id\')',
        'type'=>'raw',
        'htmlOptions'=>array('width'=>'40px',),
        //'htmlOptions'=>array('width'=>'40px'),
      ),array( //TextBox --- Displays quantity
        'header'=>'Debit',
        'value'=>'CHTML::activeNumberField($data,\'debit\')',
        'type'=>'raw',
        //'htmlOptions'=>array('width'=>'40px'),
      ),
     	array( //Update button - Doesn't work - nothing in post..
        'value'=>'CHTML::button(\'Update\',  array(\'submit\' => Yii::app()->createUrl("journal/ek")))',
        'type'=>'raw',
        'htmlOptions'=>array('width'=>'40px'),
      ),
     /* array( //Remove button - Works just fine
        'value'=>'CHTML::button(\'Remove\',  array(\'submit\' => Yii::app()->createUrl("cart/remove", array("id"=>$data->id_product))))',
        'type'=>'raw',
        'htmlOptions'=>array('width'=>'40px'),
      ),
    ),
));

echo CHtml::endForm(); 
 */?>
