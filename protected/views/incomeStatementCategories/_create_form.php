<div class="form">

<form id='create_bsc' method='POST'>

	<?php 
		/*echo CHtml::label("Value will be the total of subcategories value?",'is_total_of_subcategories');
		echo CHtml::dropDownList('is_total_of_subcategories',0,array(1=>'Yes',0=>'No'));*/
		//echo CHtml::label('Account','create-bsc-grid');
		$this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'create-bsc-grid',
			'dataProvider'=>$acct_model->search(),
			'filter'=>$acct_model,
			'columns'=>array(
				'acct_code',
				'acct_title',
				'normal_balance',
				'acct_description',
				array(
					'name'=>'report_classification',
					'header'=>'Report Classification','type'=>'html',
					'value'=>'$data->getReportClassification($data->report_classification)',
				),
				array(
					'class'=>'CButtonColumn',
					'template'=>'{add}',
					'buttons'=>array(
						'add'=>array(
							'label'=>'Add',
							'imageUrl'=>Yii::app()->baseUrl.'/images/add.png',
							'url'=>'Yii::app()->createUrl("IncomeStatementCategories/create",array("t"=>$_GET[\'t\'],"p"=>$_GET[\'p\'],"c"=>$data->acct_code,"ty"=>1))'
						),
					),
				),
			),
		));
	 ?>

</form>

</div><!-- form -->
