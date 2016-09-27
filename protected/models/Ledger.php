<?php

/**
 * This is the model class for table "Ledger".
 *
 * The followings are the available columns in table 'Ledger':
 * @property integer $jev
 * @property integer $acct_code
 * @property string $date
 * @property double $debit
 * @property double $credit
 * @property string $particulars
 *
 * The followings are the available model relations:
 * @property Account $acctCode
 */
class Ledger extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ledger the static model class
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
		return 'Ledger';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('acct_code', 'numerical', 'integerOnly'=>true),
			array('debit, credit', 'numerical'),
			array('date, particulars', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jev, acct_code, date, debit, credit, particulars', 'safe', 'on'=>'search'),
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
			'jev' => 'JEV',
			'acct_code' => 'Account Code',
			'date' => 'Date',
			'debit' => 'Debit',
			'credit' => 'Credit',
			'particulars' => 'Particulars',
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

		$criteria->compare('jev',$this->jev);
		$criteria->compare('acct_code',$this->acct_code);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('debit',$this->debit);
		$criteria->compare('credit',$this->credit);
		$criteria->compare('particulars',$this->particulars,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getLedgerAdjustedEntries($from_month, $from_year, $to_month, $to_year){

		$end_date = $to_year . " " . $to_month . " 01";
		$start_date = $from_year . " " . $from_month . " 01";

		$entries = Yii::app()->db->createCommand()
				    ->select()
				    ->from("Ledger t")
				    ->join("Account a", 't.acct_code = a.acct_code')
				    ->where( array('and', "to_date('" .$end_date. "','YYYY MM DD') > date ", "date >= to_date('" .$start_date. "','YYYY MM DD')"))
				    ->order("t.acct_code")
				    ->queryAll();
				       	
		return $entries;
	}
}