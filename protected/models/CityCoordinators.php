<?php

/**
 * This is the model class for table "city_coordinators".
 *
 * The followings are the available columns in table 'city_coordinators':
 * @property string $city_id
 * @property string $user_id
 */
class CityCoordinators extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'city_coordinators';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('city_id, user_id', 'required'),
			array('city_id, user_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('city_id, user_id', 'safe', 'on'=>'search'),
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
			'city_id' => 'City',
			'user_id' => 'User',
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
		$criteria->compare('user_id',$this->user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CityCoordinators the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function create($cityId, $userId)
	{
		$cityCoordinator = new CityCoordinators();
		$cityCoordinator->city_id = $cityId;
		$cityCoordinator->user_id = $userId;

		if ($cityCoordinator->save()) {
			return $cityCoordinator;
		}

		return false;
	}


	public function findAllByUserId($userId) {
        $key = 'city-coordinator-by-'.$userId;
        $all = LocalCache::read($key);
        if (!$all) {
            $all = self::model()->findAllByAttributes(array('user_id'=>$userId));
            LocalCache::write($key, $all);
        }
		return $all;
	}
}
