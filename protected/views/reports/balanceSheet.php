<style>
    <?php echo file_get_contents(Yii::getPathOfAlias('webroot.css').'/worksheet.css') ?>
</style>

<?php
/* @var $this ReportsController */

$this->breadcrumbs=array(
    'Reports' ,'Balance Sheet',
);
?>

<!-- <div class="row">
    <div class="col-md-4 col-xs-12"> -->
<?php 
    $this->renderPartial('_form',array(
        'yearNow'=>$yearNow,
        'yearFrom'=>$yearFrom,
        'daterange'=>$daterange,
        )
    ); 
?>
  <!--   </div>
    <div class="col-md-4 col-xs-12"> -->

<?php
    $m = isset($_POST['month_to_generate'])? $_POST['month_to_generate'] : 0;
    $y = isset($_POST['year_to_generate'])? $_POST['year_to_generate'] : 0;
   // var_dump($constants);

    $link_title = 'View PDF';
    $link_data = array("reports/balanceSheetOnPDF?m={$m}&y={$y}");
    $link_options = array(
        'class' => 'ars_btn',
        // 'style' => 'color:white;text-decoration:none;background-color:black;padding:5px;'
        'style' => 'margin-left:10px'
    );

    echo CHtml::link($link_title, $link_data, $link_options); 

    // echo "</div></div>";
     $this->renderPartial('_balancesheet',array(
        'view_data'=>$view_data,
        'daterange'=>$daterange,
        //'constants'=>$constants
        )
    );
 ?>
