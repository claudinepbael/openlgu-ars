<?php
/* @var $this BalanceSheetCategoriesController */

$this->breadcrumbs=array(
	'Balance Sheet Categories',
);
?>

<h1><b>Balance Sheet Template</b></h1>

<div>
    Edit accounts that should be shown in the balance sheet.
</div>

<?php if(Yii::app()->user->hasFlash('flash')):?>
    <div class="info" style="color:red;">
        <?php echo Yii::app()->user->getFlash('flash'); ?>
    </div>
<?php endif; ?>

<?php 	
	/*Yii::app()->user->setFlash('flashy', "Hoy.");
	Yii::app()->user->getFlash('flashy');*/
?>

<?php 

$this->menu=array(
    array('label'=>'Admin', 'url'=>array('admin')),
);

$this->widget('CTreeView',array(
        'data'=>$dataTree,
        'htmlOptions'=>array(
				'id'=>'treeview-categ',
                'class'=>'treeview-famfamfam',//there are some classes that ready to use
        ),
));

?>