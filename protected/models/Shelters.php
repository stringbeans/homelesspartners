<?php

/**
 * This is the model class for table "shelters".
 *
 * The followings are the available columns in table 'shelters':
 * @property string $shelter_id
 * @property string $city_id
 * @property string $creator_id
 * @property string $name
 * @property string $street
 * @property string $phone
 * @property string $dropoff_details
 * @property string $ID_FORMAT
 * @property string $website
 * @property string $email
 * @property integer $mapped
 * @property string $date_created
 * @property integer $enabled
 *
 * The followings are the available model relations:
 * @property Users[] $users
 */
class Shelters extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'shelters';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('city_id, creator_id, name, date_created', 'required'),
			array('mapped, enabled', 'numerical', 'integerOnly'=>true),
			array('city_id, creator_id', 'length', 'max'=>11),
			array('name, ID_FORMAT, website, email', 'length', 'max'=>128),
			array('street', 'length', 'max'=>1024),
			array('phone', 'length', 'max'=>16),
			array('dropoff_details, bio', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('shelter_id, city_id, creator_id, name, street, phone, dropoff_details, ID_FORMAT, website, email, mapped, date_created, enabled', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'users' => array(self::MANY_MANY, 'Users', 'shelter_coordinators(shelter_id, user_id)'),
            'shelterDropoffs' => array(self::HAS_MANY, 'ShelterDropoffs', 'shelter_id'),
            'city' => array(self::BELONGS_TO, 'Cities', 'city_id'),
            'stories' => array(self::HAS_MANY, 'Stories', 'shelter_id'),
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'shelter_id' => 'Shelter',
			'city_id' => 'City',
			'creator_id' => 'Creator',
			'name' => 'Name',
			'street' => 'Street',
			'phone' => 'Phone',
			'dropoff_details' => 'Dropoff Details',
			'ID_FORMAT' => 'Id Format',
			'website' => 'Website',
			'email' => 'Email',
			'mapped' => 'Mapped',
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

		$criteria->compare('shelter_id',$this->shelter_id,true);
		$criteria->compare('city_id',$this->city_id,true);
		$criteria->compare('creator_id',$this->creator_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('dropoff_details',$this->dropoff_details,true);
		$criteria->compare('ID_FORMAT',$this->ID_FORMAT,true);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('mapped',$this->mapped);
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
	 * @return Shelters the static model class
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

	public function getStorySummarybyShelterID($currentShelterId)
	{
		$sql = "
		SELECT st.story_id, st.shelter_id, shelters.name as shelter_name, shelters.website as shelter_website, shelters.bio as shelter_bio, pledges.status as pledge_status, shelters.city_id, cities.name as city_name, cities.region_id, region.name as region_name, st.creator_id, gifts.gift_id, gifts.description as gift_description, st.fname as fname, st.lname, st.assigned_id, st.story
		FROM stories st
		JOIN shelters on st.shelter_id=shelters.shelter_id
		join cities on shelters.city_id = cities.city_id
		join region on cities.region_id = region.region_id
		join gifts on st.story_id = gifts.story_id
		left join pledges on gifts.gift_id = pledges.gift_id
		WHERE st.shelter_id =	 :currentShelterId";
		$command = $this->dbConnection->createCommand($sql);
		$command->bindParam(":currentShelterId", $currentShelterId, PDO::PARAM_INT);
		return $command->queryAll();
	}

	public function getStats($shelterId = null)
	{

		if(empty($shelterId))
		{
			$shelterId = $this->shelter_id;
		}

		$sql = "
		SELECT *
		FROM (
			SELECT COUNT(*) as totalStories
			FROM stories s
			WHERE s.shelter_id = :shelterId
		) totalStories
		JOIN (
			SELECT COUNT(*) as totalGifts
			FROM gifts g 
			JOIN stories s ON g.story_id = s.story_id
			WHERE s.shelter_id = :shelterId
		) gifts 
		JOIN (
			SELECT COUNT(*) as totalPledges
			FROM gifts g 
			JOIN pledges p ON p.gift_id = g.gift_id
			JOIN stories s ON g.story_id = s.story_id
			WHERE s.shelter_id = :shelterId 
		) pledges
		";

		$command = $this->dbConnection->createCommand($sql);
		$command->bindParam(":shelterId", $shelterId, PDO::PARAM_INT);
		return $command->queryRow();
	}


public function getShelterSummary()
	{
		$sql = "
		SELECT sh.shelter_id, c.city_id, sh.name as shelter_name, c.name as city_name,
		count(distinct st.story_id) as numStories,
		count(distinct g.gift_id) as numGifts,
		count(distinct p.pledge_id) as numPledges 
		FROM shelters sh
		LEFT JOIN cities c ON c.city_id = sh.city_id
		LEFT JOIN stories st ON st.shelter_id = sh.shelter_id
		LEFT JOIN gifts g ON g.story_id = st.story_id
		LEFT JOIN pledges p ON g.gift_id = p.gift_id
		GROUP by shelter_name";
		$command = $this->dbConnection->createCommand($sql);
		return $command->queryAll();
	}

	public function getShelterSummarybyCCOUserID($currentUserId)
	{
		$sql = "
		SELECT sh.shelter_id, c.city_id, sh.name as shelter_name, c.name as city_name,
		count(distinct st.story_id) as numStories,
		count(distinct g.gift_id) as numGifts,
		count(distinct p.pledge_id) as numPledges 
		FROM shelters sh
		LEFT JOIN cities c ON c.city_id = sh.city_id
		LEFT JOIN stories st ON st.shelter_id = sh.shelter_id
		LEFT JOIN gifts g ON g.story_id = st.story_id
		LEFT JOIN pledges p ON g.gift_id = p.gift_id
		JOIN city_coordinators cco on cco.city_id = c.city_id
		WHERE cco.user_id =:currentUserId
		GROUP by shelter_name";
		$command = $this->dbConnection->createCommand($sql);
		$command->bindParam(":currentUserId", $currentUserId, PDO::PARAM_INT);
		return $command->queryAll();
	}

	public function getShelterSummarybySCOUserID($currentUserId)
	{
		$sql = "
		SELECT sh.shelter_id, c.city_id, sh.name as shelter_name, c.name as city_name,
		count(distinct st.story_id) as numStories,
		count(distinct g.gift_id) as numGifts,
		count(distinct p.pledge_id) as numPledges 
		FROM shelters sh
		LEFT JOIN cities c ON c.city_id = sh.city_id
		LEFT JOIN stories st ON st.shelter_id = sh.shelter_id
		LEFT JOIN gifts g ON g.story_id = st.story_id
		LEFT JOIN pledges p ON g.gift_id = p.gift_id
		JOIN shelter_coordinators sco on sco.shelter_id = sh.shelter_id
		WHERE sco.user_id =:currentUserId
		GROUP by shelter_name";
		$command = $this->dbConnection->createCommand($sql);
		$command->bindParam(":currentUserId", $currentUserId, PDO::PARAM_INT);
		return $command->queryAll();
	}


}
