<?php

/**
 * This is the model class for table "Label".
 *
 * The followings are the available columns in table 'Label':
 * @property integer $label_id
 * @property string $label_name
 * @property integer $report
 */
class Label extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Label the static model class
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
		return 'Label';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('label_name','required'),
			array('report', 'numerical', 'integerOnly'=>true),
			array('label_name', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('label_id, label_name, report', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'label_id' => 'Label',
			'label_name' => 'Label Name',
			'report' => 'Report',
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

		$criteria->compare('label_id',$this->label_id);
		$criteria->compare('label_name',$this->label_name,true);
		$criteria->compare('report',$this->report);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}