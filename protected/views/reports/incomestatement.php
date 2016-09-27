<style>
<?php echo file_get_contents(Yii::getPathOfAlias('webroot.css').'/worksheet.css') ?>
</style>
<?php

$this->breadcrumbs=array(
    'Reports' ,'Balance Sheet',
);
?>

<?php 
    $this->renderPartial('_form',
        array(  'yearNow'=>$yearNow,
                'yearFrom'=>$yearFrom,
                'daterange'=>$daterange
        )
    ); 
?>

<?php
    $m=isset($_POST['month_to_generate'])?$_POST['month_to_generate']:0;
    $y=isset($_POST['year_to_generate'])?$_POST['year_to_generate']:0;
?>

<?php //echo CHtml::link('View PDF', array("reports/viewISPdf?m={$m}&y={$y}")); ?>
<?php echo CHtml::link('View PDF', array("reports/incomeStatementOnPDF?m={$m}&y={$y}")); ?>



<?php $this->renderPartial('_incomestatement',array('view_data'=>$view_data,'daterange'=>$daterange)); ?>
