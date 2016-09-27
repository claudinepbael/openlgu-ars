<?php
$this->breadcrumbs=array(
	'Balance Sheet Category'=>array('index'),
	'Edit',
);

?>

<h1> Update <b>
<?php 
if($_GET['t'] == 0){	//if label
 		$criteria=new CDbCriteria;
 		$criteria->condition="label_id={$_GET['i']}";
		$data=Label::model()->find($criteria)->getAttributes();
		echo $data['label_name'];
 	}else{
 		echo Account::model()->findByPk($_GET['p'])->getAttributes('acct_title');
 	} 
?>
</b>
</h1>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
