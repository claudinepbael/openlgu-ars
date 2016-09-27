<?php
$this->breadcrumbs=array(
	'Balance Sheet Categories'=>array('index'),
	'Order',
);

?>

<h1>Order</h1>

<?php
    // Organize the dataProvider data into a Zii-friendly array
    //$items = CHtml::listData($dataProvider->getData(), 'id', 'category_acct_title');
    
    $items = CHtml::listData($data, 'id','title');
    //var_dump($data);
    // Implement the JUI Sortable plugin
    $this->widget('zii.widgets.jui.CJuiSortable', array(
        'id' => 'orderList',
        'items' => $items,
    ));
    // Add a Submit button to send data to the controller
    echo CHtml::ajaxButton(
        'Save order',
        array('IncomeStatementCategories/order','i'=>$_GET['i']),
        array(
            'data' => array(
                // Turn the Javascript array into a PHP-friendly string
                'Order' => 'js:$("ul#orderList").sortable("toArray").toString()'
                ),
            'type' => 'POST',
            'success'   => 'function(data) {
                    top.location.href="'.Yii::app()->createUrl('IncomeStatementCategories/index').'"; 
                }',
        ),//array for ajaxOptions
        array('name'=>'saveOrder')
    );

    /*echo CHtml::ajaxSubmitButton(
        'Submit request',
        array('IncomeStatementCategories/order'),
        array(
            'update'=>'#req_res02',
        )
    );*/

?>

