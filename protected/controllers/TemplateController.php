<?php

class TemplateController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionBalancesheet()
	{
		$sql= '	SELECT * from "{{Journal}}" "t" LEFT OUTER JOIN "{{Account}}" "a" ON ("t"."acct_code" = "a"."acct_code") WHERE
						to_date(\''.$to_year. ' ' .$to_month . ' 01\',\'YYYY MM DD\') > date 
				        AND date >= to_date(\''.$_POST['year_to_generate']. ' ' . $fr_month. ' 01\',\'YYYY MM DD\')
				        AND is_adjustment = \'0\' order by t.acct_code
					';
		
		$tb_data=Yii::app()->db->createCommand($sql)->queryAll();	
		$this->render('balancesheet');
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}