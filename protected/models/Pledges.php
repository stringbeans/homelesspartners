<?php

/**
 * This is the model class for table "pledges".
 *
 * The followings are the available columns in table 'pledges':
 * @property string $pledge_id
 * @property string $gift_id
 * @property string $user_id
 * @property string $date_created
 * @property integer $delivered
 */
class Pledges extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pledges';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gift_id, user_id, date_created', 'required'),
			array('delivered', 'numerical', 'integerOnly'=>true),
			array('gift_id, user_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pledge_id, gift_id, user_id, date_created, delivered', 'safe', 'on'=>'search'),
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
			'pledge_id' => 'Pledge',
			'gift_id' => 'Gift',
			'user_id' => 'User',
			'date_created' => 'Date Created',
			'delivered' => 'Delivered',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pledge_id',$this->pledge_id,true);
		$criteria->compare('gift_id',$this->gift_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('delivered',$this->delivered);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pledges the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
