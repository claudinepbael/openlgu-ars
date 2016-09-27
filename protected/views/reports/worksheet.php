<?php
/* @var $this ReportsController */

$this->breadcrumbs=array(
	'Worksheet',
);
?>

<?php $this->renderPartial('_form',array('yearNow'=>$yearNow,'yearFrom'=>$yearFrom,'daterange'=>$daterange)); ?>
<?php echo CHtml::link('View PDF',array('reports/viewPdf')); ?>


<?php $this->renderPartial('_worksheet',array('daterange'=>$daterange,'total'=>$total,'worksheet'=>$worksheet)); ?>
