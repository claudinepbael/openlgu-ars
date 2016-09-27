<?php

/**
 * This is the model class for table "IncomeStatementCategories".
 *
 * The followings are the available columns in table 'IncomeStatementCategories':
 * @property integer $type
 * @property integer $amt_type
 * @property integer $position
 * @property integer $id
 * @property integer $parent_id
 * @property integer $is_added
 */
class IncomeStatementCategories extends CActiveRecord
{

	//public $slug_update;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IncomeStatementCategories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'IncomeStatementCategories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('position, id, parent_id', 'required'),
			array('position, id, parent_id,type,amt_type,is_added', 'numerical', 'integerOnly'=>true),
			array('category_acct_title, parent_acct_title', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('position, id, parent_id,type', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations(){
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'parent' => array(self::BELONGS_TO, 'IncomeStatementCategories', 'parent_id','condition' => 't.parent_id <> 0'),
			'children' => array(self::HAS_MANY, 'IncomeStatementCategories', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'position' => 'Position',
			'id' => 'Sub-Category Account Code',
			'parent_id' => 'Category Account Code',
			'type' => 'Type',
			'amt_type' => 'Amount Type',
			'is_added' => 'Mode'
		);
	}

	const DOES_NOT_CONTAIN_AMOUNT			= -1;
	const AMOUNT_OF_DESIGNATED_ACCOUNT 		= 0;
	const AMOUNT_OF_ALL_CO_SUBCATEGORIES 	= 1;
	const AMOUNT_OF_ALL_SUBCATEGORIES 		= 2;

	const IS_LABEL_ONLY = 0;
	const IS_ACCCOUNT 	= 1;

	const BALANCE_SHEET_REPORT = 0;
	const INCOME_SHEET_REPORT = 1;

	const MAIN_CATEGORY_ID = 0;
	const INCOME_SHEET_TITLE_CATEGORY_ID = -1;
	const INCOME_SHEET_ROOT_ID = 0;


	public function amtTypeOptions(){
		return array(
			self::AMOUNT_OF_DESIGNATED_ACCOUNT	=> 'Total amount of the account',
			self::DOES_NOT_CONTAIN_AMOUNT		=> 'None',
			self::AMOUNT_OF_ALL_CO_SUBCATEGORIES=> 'Total ammount of its co-sub-accounts',
			self::AMOUNT_OF_ALL_CO_SUBCATEGORIES=> 'Total ammount of the sub-accounts',
		);
	}

	public function getAmtType($status){
		$array = self::isTotalOfSubsOptions();
		return $array[$status];
	}
		
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('position',$this->position);
		//$criteria->compare('slug',$this->slug,true);
		//$criteria->compare('category_acct_title',$this->category_acct_title,true);
		$criteria->order='parent_id, id';

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public function getMainCategoryList($dummy=0) {
		$result = Yii::app()->db->createCommand()
			->select('id, category_acct_title')
			->from('IncomeStatementCategories')
			->where('parent_id<=:id', array(':id'=>-2))
			->order('parent_id ASC, category_acct_title ASC')
			->queryAll();

		$list = array();
		foreach ($result as $row) {
			$list[$row['id']] = $row['category_acct_title']; 
		}
		if ($dummy) $list[] = 'xxx';

		return $list;
	}

	public static function dataTree($display_buttons = false) {
		$refs = array();
		$list = array();

		$result = Yii::app()->db->createCommand()
			->select('*')
			->from('IncomeStatementCategories b')
			->order('parent_id ASC, position ASC')
			->queryAll();

		foreach($result as $data) {
			$thisref = &$refs[ $data['id'] ];
			$thisref['type'] = $data['type'];	//label or account
			$thisref['amt_type'] = $data['amt_type'];	//label or account
			$thisref['is_added'] = $data['is_added'];	//label or account
			
			$thisref['parent_id'] = $data['parent_id'];
			if($thisref['type'] == self::IS_LABEL_ONLY){
				$label_condition = "label_id=".$data['id']." AND report=".self::INCOME_SHEET_REPORT;
				$title = Label::model()->find($label_condition)->getAttribute('label_name');
				$thisref['title'] = $title;
			}else{
				$thisref['title'] = Account::model()->findByPk($data['id'])->getAttribute('acct_title');
			}

			$add_image 	= CHtml::image(Yii::app()->baseUrl.'/images/add.png','add');
			$add_link 	= array('IncomeStatementCategories/create', 't'=>$data['type'],'p'=>$data['id']);
			$add_options = array('title'=>'Add Subcategory');

			$update_image = CHtml::image(Yii::app()->baseUrl.'/images/update.png','update');
			$update_link = array('IncomeStatementCategories/update', 'i'=>$data['id'],'t'=>$data['type'],'p'=>$data['parent_id']);
			$update_options = array('title'=>'Update');

			$order_image = CHtml::image(Yii::app()->baseUrl.'/images/order.png','Change order of subcategories');
			$order_link = array('IncomeStatementCategories/order', 'i'=>$data['id']);
			$order_options = array('title'=>'Change order of sub-categories');

			$delete_image = CHtml::image(Yii::app()->baseUrl.'/images/delete.png','delete');
			$delete_link = Yii::app()->baseUrl.'/index.php/IncomeStatementCategories/delete?i='.$data['id'];
			$delete_ajax_options = array(
				'type'=>'POST',
				'success'=>'function(data) {
							top.location.href="'.Yii::app()->createUrl('IncomeStatementCategories/index').'"; 
					}',
				);
			$delete_options = array(
				'href'=>Yii::app()->baseUrl.'/index.php/IncomeStatementCategories/delete?id='.$data['id'],
				'confirm' => "Are you sure you want to remove {$thisref['title']}?",
				'title'=>'Delete',
				'class'
				);

			$button = array(
				'addChild' => CHtml::link($add_image,$add_link,$add_options),
				'update' => CHtml::link($update_image, $update_link, $update_options),
				'order' => CHtml::link($order_image, $order_link , $order_options),
				'delete' => CHtml::ajaxLink($delete_image, $delete_link, $delete_ajax_options, $delete_options)
			);
			
			if ($display_buttons) {
				
				//ADD: check if has_children for Order
				if ($data['id'] >= -1) {
					$thisref['text']='';

					if($thisref['amt_type'] != self::AMOUNT_OF_ALL_CO_SUBCATEGORIES && 
						$data['id'] != self::INCOME_SHEET_TITLE_CATEGORY_ID ){
						$thisref['text'] .= ' ' . $button['addChild'];
					}
						
					if(IncomeStatementCategories::model()->find("parent_id=".$data['id'])){
						$thisref['text'] .= ' ' . $button['order'];
					}
						
					if($data['id'] != self::INCOME_SHEET_ROOT_ID){
						$thisref['text'] .= ' ' . $button['update'];
						if($thisref['parent_id'] != self::INCOME_SHEET_TITLE_CATEGORY_ID 
							&& $thisref['parent_id'] != self::INCOME_SHEET_ROOT_ID){
							$thisref['text'] .= ' ' . $button['delete'];
						}
						
						if($thisref['type'] == self::IS_LABEL_ONLY and $thisref['amt_type'] == self::AMOUNT_OF_ALL_CO_SUBCATEGORIES){
							$thisref['text'] .= "<span><i>".$thisref['title']."</i></span>";
						}else{
							$thisref['text'] .= "<span>".$thisref['title']."</span>";
						}
					}else{
						$thisref['text'] .= "<span><b>".$data['category_acct_title']."</b></span>";
					}
				}
			} else {
				$thisref['text'] = $thisref['title'];
			}

			if ($data['parent_id'] == 0) {
				$list[ $data['id'] ] = &$thisref;
			} else {
				$refs[ $data['parent_id'] ]['children'][ $data['id'] ] = &$thisref;
			}
		}
		return $list;	
	}
	
	public function beforeDelete(){

		if ($this->parent_id == 0) throw new CHttpException(400, 'The main categories can not be deleted.');

		$res = Yii::app()->db->createCommand()
			->select('COUNT(*) as cnt')
			->from('IncomeStatementCategories')
			->where('parent_id=:id', array('id'=>$this->id))
			->queryRow();

		if ($res['cnt'] > 0) throw new CHttpException(400, 'Only empty category can be deleted.');
		
		return parent::beforeDelete();
	}
	
	function existingParent() {
		if (!array_key_exists($this->parent_id, $this->getMainCategoryList())) {
			$this->addError('parent_id', 'The specified category does not exist or is not the main category.');
			return true;
		}
		return false;
	}
}