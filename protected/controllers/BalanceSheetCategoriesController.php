<?php

class BalanceSheetCategoriesController extends Controller
{

	public $layout='//layouts/column2';

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

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

	/**
	 * Handles the ordering of models.
	 */
	public function actionOrder()
	{
		// Handle the POST request data submission
		if (isset($_POST['Order'])){

			$models = explode(',', $_POST['Order']);

			for ($i = 0; $i < sizeof($models); $i++){
				if ($model = BalanceSheetCategories::model()->find("id=".$models[$i])){
					$model->position = $i+1;
					if($model->save()){
						Yii::app()->user->setFlash('flash', "ORDER UPDATED.");
					}
				}
			}
			Yii::app()->end();

		}else{ // Handle the regular model order view
			/*$dataProvider = new CActiveDataProvider('BalanceSheetCategories', array(
						'pagination' => false,
						'criteria' => array(
							'condition' => 'parent_id = ' . $_GET['id'],
							'order' => 'position ASC',
							),
						));*/
			$dataQuery = Yii::app()->db->createCommand()
										->select('*')
										->from('BalanceSheetCategories b')
										->where('parent_id=:pid', array(':pid'=>$_GET['i']))
										->leftJoin('Label l', 'l.label_id=b.id AND type=0')
										->leftJoin('Account a', 'a.acct_code=b.id AND type=1')
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
				'data' => $data, 'title' => $_GET['title']
			));
		}
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate(){

		$model 		= new BalanceSheetCategories;
		$acct_model = new Account('search');
		$acct_model->unsetAttributes();// clear any default values 

		if(isset($_GET['Account'])){
			$acct_model->attributes=$_GET['Account'];
		}

		if (isset($_GET['p'])){
			$model->parent_id = $_GET['p'];
		}
			

		if(isset($_GET['c'])){	//account
			$rec = $model->getAttributes();

			$rec['id'] 		 = (int)$_GET['c'];
			$rec['type']	 = (int)$_GET['ty'];
			$rec['is_added'] = (int)$_GET['a'];
			$rec['amt_type'] = 0;

			$pos = Yii::app()->db->createCommand()
							->select('max(position)')
							->where('parent_id = :pcac', array('pcac' => $rec['parent_id']))
							->from('BalanceSheetCategories')
							->queryRow();
			
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

		}else if(isset($_POST['BalanceSheetCategories'])){
			//$model->setAttributes($_POST['BalanceSheetCategories']);
			$rec = $model->getAttributes();

			$rec['id']			= (int)$_POST['BalanceSheetCategories']['id'];
			$rec['parent_id']	= (int)$_POST['BalanceSheetCategories']['parent_id'];
			$rec['type']		= (int)$_POST['BalanceSheetCategories']['type'];
			$rec['is_added']	= (int)$_POST['BalanceSheetCategories']['is_added'];
			
			$pos = Yii::app()->db->createCommand()
							->select('max(position)')
							->where('parent_id = :pcac', array('pcac'=>$rec['parent_id']))
							->from('BalanceSheetCategories')
							->queryRow();
			
			if(!$pos['max']){
				$rec['position'] = 1;
			}else{
				$rec['position'] = $pos['max']+1;
			}

			if($rec['type'] == 1){//if account
				$rec['amt_type']=0;
			}

			var_dump($model);
			$model->setAttributes($rec);
			if($model->save()) {
				Yii::app()->user->setFlash('flash', "Create succesful.");
				$this->redirect(array('index'));
			}

		}

		$this->render('create',array(
			'model' => $model,
			'acct_model' => $acct_model,	
		));
	}

	public function actionCreateWithLabel(){

		$labelModel = new Label;
		//Yii::app()->clientScript->registerScript('Create label',"alert({$_POST})");
		
		if(isset($_POST['Label'])){

			$labelModel->attributes = $_POST['Label'];
			if($labelModel->save()){
				
				$savedModel = Label::model()->find("l_pk=".$labelModel->getAttribute('l_pk'));
				//var_dump($savedModel->getAttributes());
				//var_dump($_POST['BalanceSheetCategories']);
				$bsModel = new BalanceSheetCategories;
				$bsModel->attributes = $_POST['BalanceSheetCategories'];
				//$bs=$_POST['Label'];
				//$bs['parent_id']->$_POST['BalanceSheetCategories']['parent_id'];
				//$bs['amt_type']->$_POST['BalanceSheetCategories']['amt_type'];
				//$bs['id']=$labelModel->getAttribute('label_id');
				$bs['id'] = $savedModel->getAttribute('label_id');
				$bs['type'] = 0;	

				$pos=Yii::app()->db->createCommand()
							->select('max(position)')
							->where('parent_id = :pcac', array('pcac'=>$bsModel->getAttribute('parent_id')))
							->from('BalanceSheetCategories')
							->queryRow();
				
				if(!$pos['max']){
					$bs['position'] = 1;
				}else{
					$bs['position'] = $pos['max']+1;
				}

				$bsModel->setAttributes($bs);
				if($bsModel->save()) {
					Yii::app()->user->setFlash('flash', "Create succesful.");
				}
			}
			echo "Label";
			var_dump($labelModel->getAttributes());
			//$this->redirect(array('index'));
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate(){

		$id = $_GET['i'];
		if($id == 0){
			Yii::app()->user->setFlash('flash', "The main categories are not editable.");
			$this->redirect(array('index'));
		}

		$model = $this->loadModel($id);

		if(isset($_POST['BalanceSheetCategories'])){
			$model->attributes = $_POST['BalanceSheetCategories'];
			if($model->save()) {
				Yii::app()->user->setFlash('flash', "Update succesful.");
				$this->redirect(array('index','id'=>$model->id));
			}
		}
		
		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete(){
		$id=$_GET['i'];
		echo $id;
		$this->render('_test');
		if(Yii::app()->request->isPostRequest){
			// we only allow deletion via POST request
			try {
				$this->loadModel($id)->delete();
				Yii::app()->user->setFlash('flash', "Successfully deleted category.");
			} catch (Exception $e) {
				Yii::app()->user->setFlash('flash', $e->getMessage());
			}

		}else{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex(){
		$dataProvider=new CActiveDataProvider('BalanceSheetCategories');
		$this->render('index',array(
			'dataTree'=>BalanceSheetCategories::generateDataTree(true),
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin(){

		$model = new BalanceSheetCategories('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['BalanceSheetCategories'])){
			$model->attributes=$_GET['BalanceSheetCategories'];
		}

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
		$model=BalanceSheetCategories::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='BalanceSheetCategories-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}