<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $user_id
 * @property string $email
 * @property string $pw
 * @property string $role
 * @property string $date_created
 * @property integer $enabled
 * @property string $role_new
 *
 * The followings are the available model relations:
 * @property Cities[] $cities
 * @property Shelters[] $shelters
 */
class Users extends CActiveRecord
{

	const ROLE_ADMIN = 'admin';
	const ROLE_CITY = 'city';
	const ROLE_SHELTER = 'shelter';
	const ROLE_CONTRIBUTOR = 'contributor';
	const ROLE_USER = 'user';

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, pw, date_created', 'required'),
			array('enabled', 'numerical', 'integerOnly'=>true),
			array('email, role', 'length', 'max'=>255),
			array('pw', 'length', 'max'=>16),
			array('role_new', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, email, pw, role, date_created, enabled, role_new', 'safe', 'on'=>'search'),
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
			'cities' => array(self::MANY_MANY, 'Cities', 'city_coordinators(user_id, city_id)'),
			'shelters' => array(self::MANY_MANY, 'Shelters', 'shelter_coordinators(user_id, shelter_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'email' => 'Email',
			'pw' => 'Pw',
			'role' => 'Role',
			'date_created' => 'Date Created',
			'enabled' => 'Enabled',
			'role_new' => 'Role New',
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

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('pw',$this->pw,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('enabled',$this->enabled);
		$criteria->compare('role_new',$this->role_new,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function create($email, $password, $role = self::ROLE_USER)
	{
		$user = new Users();
		$user->email = $email;
		$user->pw = $password;
		$user->role_new = $role;
		$user->date_created = new CDbExpression('NOW()');

		if($user->save())
		{
			return $user;
		}

		return false;
	}
}
