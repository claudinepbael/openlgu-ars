<?php

/**
 * This is the model class for table "Journal".
 *
 * The followings are the available columns in table 'Journal':
 * @property integer $j_id
 * @property integer $acct_code
 * @property string $date
 * @property double $debit
 * @property double $credit
 * @property string $description
 * @property integer $is_adjustment
 *
 * The followings are the available model relations:
 * @property Account $acctCode
 */
class Journal extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Journal the static model class
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
		return 'Journal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('acct_code, is_adjustment', 'numerical', 'integerOnly'=>true),
			array('debit, credit', 'numerical'),
			array('date, description', 'safe'),
			array('acct_code, date','required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('j_id, acct_code, date, debit, credit, description, is_adjustment', 'safe', 'on'=>'search'),
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
			'acctCode' => array(self::BELONGS_TO, 'Account', 'acct_code'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'j_id' => 'J',
			'acct_code' => 'Acct Code',
			'date' => 'Date',
			'debit' => 'Debit',
			'credit' => 'Credit',
			'description' => 'Description',
			'is_adjustment' => 'Is Adjustment',
		);
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

		$criteria->compare('j_id',$this->j_id);
		$criteria->compare('acct_code',$this->acct_code);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('debit',$this->debit);
		$criteria->compare('credit',$this->credit);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('is_adjustment',$this->is_adjustment);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}