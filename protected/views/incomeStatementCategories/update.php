<?php
$this->breadcrumbs=array(
	'Income Statement Category'=>array('index'),
	'Edit',
);

?>

<h1> Update 
	<?php 
	if($_GET['t'] == 0){	//if label
		echo $model['label_name'];
	}else{
		echo $acct_model['acct_title'];
	}
?>
</h1>

<?php
	if($_GET['t'] == 0){	//if label
		echo $this->renderPartial('_create_label_form', 
			array(	'model'=>$model,
					'is_model'=>$is_model,
					'to_update'=>true)
		);
	}else{
		echo $this->renderPartial('_create_form', 
			array(	'model'=>$model,
					'acct_model'=>$acct_model,
					'to_update'=>true
				)
		); 
	}
?>

