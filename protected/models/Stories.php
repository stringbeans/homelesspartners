<?php

/**
 * This is the model class for table "stories".
 *
 * The followings are the available columns in table 'stories':
 * @property string $story_id
 * @property string $shelter_id
 * @property string $creator_id
 * @property string $fname
 * @property string $lname
 * @property string $gender
 * @property string $assigned_id
 * @property string $story
 * @property string $display_order
 * @property string $date_created
 * @property integer $enabled
 */
class Stories extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'stories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shelter_id, creator_id, date_created', 'required'),
			array('enabled', 'numerical', 'integerOnly'=>true),
			array('shelter_id, creator_id, display_order', 'length', 'max'=>11),
			array('fname', 'length', 'max'=>50),
			array('lname, gender', 'length', 'max'=>1),
			array('assigned_id', 'length', 'max'=>32),
			array('story', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('story_id, shelter_id, creator_id, fname, lname, gender, assigned_id, story, display_order, date_created, enabled', 'safe', 'on'=>'search'),
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
			'story_id' => 'Story',
			'shelter_id' => 'Shelter',
			'creator_id' => 'Creator',
			'fname' => 'Fname',
			'lname' => 'Lname',
			'gender' => 'Gender',
			'assigned_id' => 'Assigned',
			'story' => 'Story',
			'display_order' => 'Display Order',
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

		$criteria->compare('story_id',$this->story_id,true);
		$criteria->compare('shelter_id',$this->shelter_id,true);
		$criteria->compare('creator_id',$this->creator_id,true);
		$criteria->compare('fname',$this->fname,true);
		$criteria->compare('lname',$this->lname,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('assigned_id',$this->assigned_id,true);
		$criteria->compare('story',$this->story,true);
		$criteria->compare('display_order',$this->display_order,true);
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
	 * @return Stories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
