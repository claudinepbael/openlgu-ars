<?php

/**
 * This is the model class for table "Account".
 *
 * The followings are the available columns in table 'Account':
 * @property integer $acct_code
 * @property string $acct_title
 * @property string $normal_balance
 * @property string $acct_description
 * @property string $report_classification
 *
 * The followings are the available model relations:
 * @property Journal[] $journals
 */
class Account extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Account the static model class
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
		return 'Account';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('acct_code', 'required'),
			array('acct_code', 'numerical', 'integerOnly'=>true),
			array('normal_balance', 'length', 'max'=>10),
			array('report_classification', 'length', 'max'=>20),
			array('acct_title, acct_description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('acct_code, acct_title, normal_balance, acct_description, report_classification', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'journals' => array(self::HAS_MANY, 'Journal', 'acct_code'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'acct_code' => 'Account Code',
			'acct_title' => 'Account Title',
			'normal_balance' => 'Normal Balance',
			'acct_description' => 'Account Description',
			'report_classification' => 'Report Classification',
		);
	}

	const B_S = 'B';
	const I_S = 'I';

	public function reportClassification(){
		return array(
			self::B_S=>'Balance Sheet',
			self::I_S=>'Income Statement',
		);
	}

	public function getReportClassification($status){
		$array = self::reportClassification();
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

		$criteria->compare('acct_code',$this->acct_code);
		$criteria->compare('acct_title',$this->acct_title,true);
		$criteria->compare('normal_balance',$this->normal_balance,true);
		$criteria->compare('acct_description',$this->acct_description,true);
		$criteria->compare('report_classification',$this->report_classification,true);
		$criteria->order='acct_code';
		//$criteria->order('acct_code');
		//var_dump($criteria);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>25),
		));
	}
}