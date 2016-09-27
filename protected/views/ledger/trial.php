<?php
/* @var $this LedgerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ledgers',
);

$this->menu=array(
	array('label'=>'Create Ledger', 'url'=>array('create')),
	array('label'=>'Manage Ledger', 'url'=>array('admin')),
);
?>

<h1>Ledgers Trial</h1>

<b>DEBITED</b>

<?php 
/*$this->widget('zii.widgets.CDetailView', array(
	'data'=>$all,
	'attributes'=>array(
		'ldgr_id',
		'acct_no',
		't_date',
		'debit',
		'credit',
	),*/
//)); ?>



<b>data provider</b>
<? $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<table>
<?php 
	 foreach($data as $item){
?>		<tr>
			 <td><?php echo $item['credit'];?></td>
			 <td><?php echo $item['debit'];?></td>
		</tr>
<?php	
	 }
?>
</table>
<?php 
/*		$flashChart = Yii::createComponent('application.extensions.yiiopenflashchart.EOFC2');

	$flashChart->begin();
	$flashChart->setData($try);
	$flashChart->renderData('line');
	$flashChart->render(300, 200);*/
?>

<?php 

// var_dump($data);
// var_dump($try);
?>
