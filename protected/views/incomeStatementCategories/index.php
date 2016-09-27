<?php

    $this->breadcrumbs=array(
    	'Income Statement Categories',
    );
?>

<h1>
    <b>Income Statement Categories</b>
</h1>

<?php if(Yii::app()->user->hasFlash('flash')):?>
    <div class="info" style="color:red;">
        <?php echo Yii::app()->user->getFlash('flash'); ?>
    </div>
<?php endif; ?>

<?php 

$this->menu=array(
    array('label'=>'Admin', 'url'=>array('admin')),
);

$this->widget('CTreeView',array(
        'data' => $dataTree,
        'htmlOptions'=>array(
				'id'=>'treeview-categ',
                'class'=>'treeview-famfamfam',//there are some classes that are ready to use
        ),
));

?>