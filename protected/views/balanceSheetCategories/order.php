<?php
$this->breadcrumbs=array(
	'Balance Sheet Categories'=>array('index'),
	'Order',
);

?>

<h1>Change <?php echo $title; ?> sub-categories order </h1>

<br/>
<i>Drag each sub-category to the desired place in the list</i>
<br/><br/>

<?php
        
    $items = CHtml::listData($data, 'id','title');
    // Implement the JUI Sortable plugin
    $this->widget('zii.widgets.jui.CJuiSortable', array(
        'id' => 'orderList',
        'items' => $items,
    ));
    // Add a Submit button to send data to the controller
    echo CHtml::ajaxButton(
        'Save order',
        array('BalanceSheetCategories/order','i' => $_GET['i']),
        array(
            'data' => array(
                // Turn the Javascript array into a PHP-friendly string
                'Order' => 'js:$("ul#orderList").sortable("toArray").toString()'
                ),
            'type' => 'POST',
            'success'   => 'function(data) {
                    top.location.href="'.Yii::app()->createUrl('BalanceSheetCategories/index').'"; 
                }',
        ),//array for ajaxOptions
        array('name'=>'saveOrder')
    );

?>

