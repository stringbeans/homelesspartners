<?php

/**
 * This is the model class for table "gifts".
 *
 * The followings are the available columns in table 'gifts':
 * @property string $gift_id
 * @property string $story_id
 * @property string $description
 * @property string $date_created
 * @property integer $enabled
 */
class Gifts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gifts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('story_id, date_created', 'required'),
			array('enabled', 'numerical', 'integerOnly'=>true),
			array('story_id', 'length', 'max'=>11),
			array('description', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('gift_id, story_id, description, date_created, enabled', 'safe', 'on'=>'search'),
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
			'gift_id' => 'Gift',
			'story_id' => 'Story',
			'description' => 'Description',
			'date_created' => 'Date Created',
			'enabled' => 'Enabled',
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

		$criteria->compare('gift_id',$this->gift_id,true);
		$criteria->compare('story_id',$this->story_id,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('enabled',$this->enabled);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Gifts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
