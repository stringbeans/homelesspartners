<?php

/**
 * This is the model class for table "cities".
 *
 * The followings are the available columns in table 'cities':
 * @property string $city_id
 * @property string $region_id
 * @property string $name
 * @property integer $enabled
 * @property string $img
 * @property integer $mapped
 *
 * The followings are the available model relations:
 * @property Users[] $users
 */
class Cities extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cities';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('region_id, name', 'required'),
			array('enabled, mapped', 'numerical', 'integerOnly'=>true),
			array('region_id', 'length', 'max'=>11),
			array('name', 'length', 'max'=>32),
			array('img', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('city_id, region_id, name, enabled, img, mapped', 'safe', 'on'=>'search'),
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
			'users' => array(self::MANY_MANY, 'Users', 'city_coordinators(city_id, user_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'city_id' => 'City',
			'region_id' => 'Region',
			'name' => 'Name',
			'enabled' => 'Enabled',
			'img' => 'Img',
			'mapped' => 'Mapped',
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

		$criteria->compare('city_id',$this->city_id,true);
		$criteria->compare('region_id',$this->region_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('enabled',$this->enabled);
		$criteria->compare('img',$this->img,true);
		$criteria->compare('mapped',$this->mapped);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cities the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
