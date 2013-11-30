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
            'region' => array(self::BELONGS_TO, 'Region', 'region_id'),
            'users' => array(self::MANY_MANY, 'Users', 'city_coordinators(city_id, user_id)'),
            'shelters' => array(self::HAS_MANY, 'Shelters', 'city_id'),
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


	public function getShelterCountbyCity($shelterIds = array())
	{
		$sql = "
        SELECT count(s.shelter_id) as scount, c.name
        FROM shelters s
        JOIN cities c ON c.city_id = s.city_id
		GROUP BY c.name
		ORDER BY s.shelter_id ASC";

        $command = $this->dbConnection->createCommand($sql);
        return $command->queryAll();
	}

	public function getSheltersWithTotalStoryCount($currentCityId)
	{
		$sql = "
		SELECT region.name as region_name, cities.name as city_name, shelters.shelter_id, shelters.they_do as shelter_description, shelters.name as shelter_name, count(stories.story_id) as total_stories
		FROM shelters
		join cities on shelters.city_id = cities.city_id
		join region on cities.region_id = region.region_id
		join stories on shelters.shelter_id = stories.shelter_id
		join gifts on stories.story_id = gifts.story_id
		join pledges on gifts.gift_id = pledges.gift_id
		WHERE cities.city_id =:currentCityId
		GROUP BY region_name, city_name, shelter_name";
		$command = $this->dbConnection->createCommand($sql);
		$command->bindParam(":currentCityId", $currentCityId, PDO::PARAM_INT);
		return $command->queryAll();
	}


	



public function getSheltersWithTotalPledges($currentCityId)
	{
		$sql = "
SELECT 
*
FROM (
SELECT 
	region.name as region_name, 
	cities.city_id, 
	cities.name as city_name, 
	shelters.shelter_id, 
	shelters.name as shelter_name, 
	shelters.bio as shelter_bio,
	count(stories.story_id) as total_stories
	#count(gifts.gift_id) as numGifts
	#'' as num of pledged gifts
FROM shelters
join cities on shelters.city_id = cities.city_id
join region on cities.region_id = region.region_id
join stories on shelters.shelter_id = stories.shelter_id
join gifts on stories.story_id = gifts.story_id
join pledges on gifts.gift_id = pledges.gift_id
GROUP BY region_name, city_name, shelter_name
) a
LEFT JOIN (
SELECT c.city_id, count(g.gift_id) as numGifts
FROM cities c
JOIN shelters s ON c.city_id = s.city_id
JOIN stories st ON st.shelter_id = s.shelter_id
JOIN gifts g ON g.story_id = st.story_id
group by c.city_id
) b ON a.city_id = b.city_id
LEFT JOIN (
SELECT c.city_id, count(p.pledge_id) as numPledges
FROM cities c
JOIN shelters s ON c.city_id = s.city_id
JOIN stories st ON st.shelter_id = s.shelter_id
JOIN gifts g ON g.story_id = st.story_id
JOIN pledges p ON p.gift_id = g.gift_id
group by c.city_id

) c ON b.city_id = c.city_id
		WHERE c.city_id =:currentCityId";


		
		$command = $this->dbConnection->createCommand($sql);
		$command->bindParam(":currentCityId", $currentCityId, PDO::PARAM_INT);
		return $command->queryAll();
	}



public function getCitySummary()
	{
		$sql = "
		SELECT c.city_id, r.region_id, c.name as name,
		count(distinct sh.shelter_id) as numShelters,
		count(distinct st.story_id) as numStories,
		count(distinct g.gift_id) as numGifts,
		count(distinct p.pledge_id) as numPledges 
		FROM cities c
		JOIN region r on r.region_id = c.region_id
		LEFT JOIN shelters sh ON c.city_id = sh.city_id
		LEFT JOIN stories st ON st.shelter_id = sh.shelter_id
		LEFT JOIN gifts g ON g.story_id = st.story_id
		LEFT JOIN pledges p ON g.gift_id = p.gift_id
		group by c.city_id";
		$command = $this->dbConnection->createCommand($sql);
		return $command->queryAll();
	}

	public function getCitySummarybyUserID($currentUserId)
	{
		$sql = "
		SELECT c.city_id, r.region_id, c.name as name,
		count(distinct sh.shelter_id) as numShelters,
		count(distinct st.story_id) as numStories,
		count(distinct g.gift_id) as numGifts,
		count(distinct p.pledge_id) as numPledges 
		FROM cities c
		JOIN region r on r.region_id = c.region_id
		LEFT JOIN shelters sh ON c.city_id = sh.city_id
		LEFT JOIN stories st ON st.shelter_id = sh.shelter_id
		LEFT JOIN gifts g ON g.story_id = st.story_id
		LEFT JOIN pledges p ON g.gift_id = p.gift_id
		JOIN city_coordinators cco on cco.city_id = c.city_id
		WHERE cco.user_id =:currentUserId
		group by c.city_id;";
		$command = $this->dbConnection->createCommand($sql);
		$command->bindParam(":currentUserId", $currentUserId, PDO::PARAM_INT);
		return $command->queryAll();
	}




}
