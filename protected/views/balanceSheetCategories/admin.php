<?php
$this->breadcrumbs=array(
	'Balance Sheet Categories'=>array('index'),
	'Admin',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('category-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Category Admin</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'category_acct_code',
		'parent_category_acct_code',
		'position',
		'category_acct_title',
		array('name'=>'is_total_of_subcategories','header'=>'Amount will be the total of subcategories','type'=>'html','value'=>'$data->isTotalofSubs($data->is_total_of_subcategories)'),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}',			
		),
	),
)); ?>
