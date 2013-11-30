<?php

/**
 * This is the model class for table "country".
 *
 * The followings are the available columns in table 'country':
 * @property string $country_id
 * @property string $name
 */
class Country extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'country';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('country_id, name', 'safe', 'on'=>'search'),
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
			'country_id' => 'Country',
			'name' => 'Name',
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

		$criteria->compare('country_id',$this->country_id,true);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Country the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


public function getCountrySummary()
	{
		$sql = "
		SELECT country.country_id, country.name as name,
		count(distinct r.region_id) as numRegions,
		count(distinct c.city_id) as numCities,
		count(distinct s.shelter_id) as numShelters
		FROM country 
		JOIN region r on country.country_id = r.country_id
		LEFT JOIN cities c on c.region_id = r.region_id
		LEFT JOIN shelters s ON c.city_id = s.city_id
		group by country.country_id";
		$command = $this->dbConnection->createCommand($sql);
		return $command->queryAll();
	}



}
