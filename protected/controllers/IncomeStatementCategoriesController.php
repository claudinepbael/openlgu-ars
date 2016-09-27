<?php

class IncomeStatementCategoriesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';


	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				//'actions'=>array(),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				//'actions'=>array('admin','delete'),
				'actions'=>array('index','create','update', 'admin', 'delete', 'order'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	const DOES_NOT_CONTAIN_AMOUNT			= -1;
	const AMOUNT_OF_DESIGNATED_ACCOUNT 		= 0;
	const AMOUNT_OF_ALL_CO_SUBCATEGORIES 	= 1;
	const AMOUNT_OF_ALL_SUBCATEGORIES 		= 2;

	const IS_LABEL_ONLY = 0;
	const IS_ACCCOUNT 	= 1;

	/**
	 * Handles the ordering of models.
	 */
	public function actionOrder()
	{
		// Handle the POST request data submission
		if (isset($_POST['Order'])){

			$models = explode(',', $_POST['Order']);

			for ($i = 0; $i < sizeof($models); $i++){
				if ($model = IncomeStatementCategories::model()->find("id=".$models[$i]) ){
					$model->position = $i+1;
					if($model->save()){
						Yii::app()->user->setFlash('flash', "ORDER UPDATED.");
					}
				}
			}
			Yii::app()->end();
		}
		// Handle the regular model order view
		else{
			$dataQuery = Yii::app()->db->createCommand()
				->select('*')
				->from('IncomeStatementCategories')
				->where('parent_id=:pid',array(':pid'=>$_GET['i']))
				->leftJoin('Label l', 'l.label_id=id AND type=0')
				->leftJoin('Account a', 'a.acct_code=id AND type=1')
				->order('position ASC')
				->queryAll();

			$data=array();
			foreach ($dataQuery as $key => $value) {
				$data[$key]['id']=$value['id'];
				if($value['type']==0){	//label
					$data[$key]['title']=$value['label_name'];
				}else{
					$data[$key]['title']=$value['acct_title'];
				}
			}

			$this->render('order',array(
					'data' => $data,
				));
		}
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new IncomeStatementCategories();
		$acct_model = new Account('search');
		$acct_model->unsetAttributes();// clear any default values 


		if(isset($_GET['Account'])){
			$acct_model->attributes=$_GET['Account'];
		}

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);
		if (isset($_GET['p']))
			$model->parent_id = $_GET['p'];

		if(isset($_GET['c'])){	//account
			$rec = $model->getAttributes();

			$rec['id'] = (int)$_GET['c'];
			$rec['type'] = (int)$_GET['ty'];
			$rec['amt_type'] = 0;

			$pos=Yii::app()->db->createCommand()
					->select('max(position)')
					->where('parent_id = :pcac',
						array('pcac'=>$rec['parent_id']))
					->from('IncomeStatementCategories')->queryRow();
			;
			
			if(!$pos['max']){
				$rec['position'] = 1;
			}else{
				$rec['position'] = $pos['max']+1;
			}
			$model->setAttributes($rec);

			if($model->save()) {
					Yii::app()->user->setFlash('flash', "Create succesful.");
					$this->redirect(array('index'));
			}
			
		}

		else if(isset($_POST['IncomeStatementCategories'])){
			//$model->setAttributes($_POST['IncomeStatementCategories']);
			$rec = $model->getAttributes();
			$rec['id'] = (int)$_POST['IncomeStatementCategories']['id'];
			$rec['parent_id'] = (int)$_POST['IncomeStatementCategories']['parent_id'];
			$rec['type'] = (int)$_POST['IncomeStatementCategories']['type'];
			$pos=Yii::app()->db->createCommand()
					->select('max(position)')
					->where('parent_id = :pcac',
						array('pcac'=>$rec['parent_id']))
					->from('IncomeStatementCategories')->queryRow();
			;
			
			if(!$pos['max']){
				$rec['position']=1;
			}else{
				$rec['position']=$pos['max']+1;
			}

			if($rec['type'] == 1){//account (not label)
				$rec['amt_type'] = 0; //as is amount
			}

			if($model->save()) {
					Yii::app()->user->setFlash('flash', "Create succesful.");
					$this->redirect(array('index'));
			}

		}

		$this->render('create',array(
			'model'=>$model,
			'acct_model'=>$acct_model,
			'to_update'=>false,
		));
	}

	public function actionCreateWithLabel(){
		
		$lModel=new Label;

		if(isset($_POST['Label']))
		{
			$lModel->attributes=$_POST['Label'];
			if($lModel->save()){
				$bsModel= new IncomeStatementCategories;
				$bsModel->attributes=$_POST['IncomeStatementCategories'];
				$bs['id']= Label::model()->find("l_pk=".$lModel->getAttribute('l_pk'))->getAttribute('label_id');
				$bs['type']=0;

				$pos=Yii::app()->db->createCommand()
					->select('max(position)')
					->where('parent_id = :pcac',
						array('pcac'=>$bsModel->getAttribute('parent_id')))
					->from('IncomeStatementCategories')->queryRow();
				;
				
				if(!$pos['max']){
					$bs['position']=1;
				}else{
					$bs['position']=$pos['max']+1;
				}

				$bsModel->setAttributes($bs);
				echo "BSC";
				var_dump($bsModel);

				if($bsModel->save()) {
						Yii::app()->user->setFlash('flash', "Create succesful.");
						//$this->redirect(array('index'));
					}
				}
				echo "Label";
				var_dump($lModel->getAttributes());
				$this->redirect(array('index'));
		}

		/*$this->render('create',array(
			'model'=>$model,
		));*/
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
		$id = $_GET['i'];
		if ($id==0) {
			Yii::app()->user->setFlash('flash', "The main categories are not editable.");
			$this->redirect(array('index'));
		}

		$is_model = IncomeStatementCategories::model()->find("id=".$id);
		
		if( $_GET['t'] == self::IS_LABEL_ONLY){
			$label_model = Label::model()->find("label_id=".$id);
			$model = $label_model;
			if(isset($_POST['Label'])){
				$model->attributes=$_POST['Label'];
				if($model->save()) {
					//Yii::app()->user->setFlash('flash', "Update succesful.");
					//$this->redirect(array('index'));
					//return;
				}
			}

			if(isset($_POST['IncomeStatementCategories'])){

				$is_model->attributes = $_POST['IncomeStatementCategories'];
				if($is_model->save()) {
					Yii::app()->user->setFlash('flash', "Update succesful.");
					$this->redirect(array('index'));
				}
			}


		}else{
			$model = $this->loadModel($id);
		}

		$acct_model = new Account('search');
		$acct_model->unsetAttributes();

		if(isset($_POST['IncomeStatementCategories'])){

			$model->attributes = $_POST['IncomeStatementCategories'];
			if($model->save()) {
				Yii::app()->user->setFlash('flash', "Update succesful.");
				$this->redirect(array('index'));
			}
		}
	
		$this->render('update',array(
			'model'		=> $model,
			"acct_model"=> $acct_model,
			'is_model'	=> $is_model,
			'to_update'	=> true,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		$id=$_GET['i'];
		echo $id;
		$this->render('_test');
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			try {
				$this->loadModel($id)->delete();
				Yii::app()->user->setFlash('flash', "Successfully deleted category.");
			} catch (Exception $e) {
				Yii::app()->user->setFlash('flash', $e->getMessage());
			}

		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('IncomeStatementCategories');
		$this->render('index',array(
			'dataTree'=>IncomeStatementCategories::dataTree(true),
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new IncomeStatementCategories('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['IncomeStatementCategories']))
			$model->attributes=$_GET['IncomeStatementCategories'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=IncomeStatementCategories::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='IncomeStatementCategories-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}