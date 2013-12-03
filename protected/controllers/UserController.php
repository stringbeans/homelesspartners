<?php

class UserController extends Controller
{

	public function actionIndex()
	{
		//fetch all cities
		$users = Users::model()->findAll(array('order' => 'CONCAT(role) ASC'));

		$rolesLookup = array(
			Users::ROLE_ADMIN => 'Administrator',
			Users::ROLE_CITY => 'City Coordinator',
			Users::ROLE_SHELTER => 'Shelter Manager',
			Users::ROLE_CONTRIBUTOR => 'Typist',
			Users::ROLE_USER => 'User',
		);

		$this->render("/user/index/main", array(
			'users' => $users,
			'rolesLookup' => $rolesLookup
		));
	}
	
	public function actionEdit()
	{
		Yii::app()->clientScript->registerCssFile('/css/selectize.bootstrap3.css');
		Yii::app()->clientScript->registerScriptFile('/js/flatui-checkbox.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile('/js/selectize.min.js', CClientScript::POS_END);
		//Yii::app()->clientScript->registerScriptFile('/js/jquery.validate.js', CClientScript::POS_END);

		$userId = Yii::app()->input->get("id");

		$user = null;
		if(!empty($userId))
		{
			$user = Users::model()->findByPk($userId);
		}

		

		$selectedCitiesLookup = array();
		if(isset($user) && $user->role == Users::ROLE_CITY)
		{
			$selectedCities = CityCoordinators::model()->findAllByAttributes(array('user_id' => $userId));
			
			foreach($selectedCities as $selectedCity)
			{
				$selectedCitiesLookup[$selectedCity->city_id] = true;
			}
		}
		elseif(isset($user) && $user->role == Users::ROLE_CONTRIBUTOR)
		{
			$selectedCities = CityContributor::model()->findAllByAttributes(array('user_id' => $userId));
			
			foreach($selectedCities as $selectedCity)
			{
				$selectedCitiesLookup[$selectedCity->city_id] = true;
			}
		}
			
		$shelters = Shelters::model()->findAll();

		$selectedSheltersLookup = array();
		if (isset($user) && $user->role == Users::ROLE_SHELTER) {
			$selectedShelters = ShelterCoordinators::model()->findAllByAttributes(array('user_id' => $userId));
			
			foreach ($selectedShelters as $selectedShelter) {
				$selectedSheltersLookup[$selectedShelter->shelter_id] = true;
			}
		}
		elseif (isset($user) && $user->role == Users::ROLE_CONTRIBUTOR) {
			$selectedShelters = ShelterContributor::model()->findAllByAttributes(array('user_id' => $userId));
			
			foreach ($selectedShelters as $selectedShelter) {
				$selectedSheltersLookup[$selectedShelter->shelter_id] = true;
			}
		}

		$roles = array();
		$cities = array();
		if(Yii::app()->user->role == Users::ROLE_ADMIN)
		{
			$roles = array(
				Users::ROLE_ADMIN => 'Administrator',
				Users::ROLE_CITY => 'City Coordinator',
				Users::ROLE_SHELTER => 'Shelter Manager',
				Users::ROLE_CONTRIBUTOR => 'Typist',
				Users::ROLE_USER => 'User',
			);

			$cities = Cities::model()->findAll();
		}
		if(Yii::app()->user->role == Users::ROLE_CITY)
		{
			$roles = array(
				Users::ROLE_SHELTER => 'Shelter Manager',
				Users::ROLE_CONTRIBUTOR => 'Contributor',
			);

			$cityCoordinators = CityCoordinators::model()->findAllByAttributes(array('user_id' => Yii::app()->user->id));
			$allowedCityIds = array();
			foreach($cityCoordinators as $cc)
			{
				$allowedCityIds[] = $cc->city_id;
			}

			if(!empty($allowedCityIds))
			{
				$cities = Cities::model()->findAll(array(
					'condition' => 't.city_id IN ('.implode(",", $allowedCityIds).')'
				));
			}
		}

		$this->render("/user/edit/main", array(
			'user' => $user,
			'roles' => $roles,
			'cities' => $cities,
			'selectedCitiesLookup' => $selectedCitiesLookup,
			'shelters' => $shelters,
			'selectedSheltersLookup' => $selectedSheltersLookup
		));
	}

	public function actionSave() 
	{
		$userId = Yii::app()->input->post("userId");
		$password = Yii::app()->input->post("password");
		$email = Yii::app()->input->post("email");
		$name = Yii::app()->input->post("name");
		$role = Yii::app()->input->post("role");
		$cityIds = Yii::app()->input->post("cityIds", array());
		$shelterIds = Yii::app()->input->post("shelterIds", array());

		if (empty($email)) {
			Yii::app()->user->setFlash('error', "Please enter an email.");
			$this->redirect($this->createUrl("user/edit", array(
				'id' => $userId
			)));
		}

		if (!empty($userId)) {
			$user = Users::model()->findByPk($userId);
			$user->email = $email;
			if (!empty($password))
			{
				$user->pw = $password;
			}
			$user->role = $role;
			$user->name = $name;
			$user->save();
			Yii::app()->user->setFlash('success', $name . '\'s account has been saved.');

			CityCoordinators::model()->deleteAllByAttributes(array('user_id' => $userId));
			ShelterCoordinators::model()->deleteAllByAttributes(array('user_id' => $userId));
			CityContributor::model()->deleteAllByAttributes(array('user_id' => $userId));
			ShelterContributor::model()->deleteAllByAttributes(array('user_id' => $userId));
		}
		else {
			$user = Users::model()->create($name, $email, $password, $role);
			Yii::app()->user->setFlash('success', 'New user "' . $name . '" has been created.');
		}

		if ($role == Users::ROLE_CITY) {
			foreach($cityIds as $cityId) {
				CityCoordinators::model()->create($cityId, $user->user_id);
			}
		} elseif ($role == Users::ROLE_SHELTER) {
			foreach($shelterIds as $shelterId) {
				ShelterCoordinators::model()->create($shelterId, $user->user_id);
			}
		} elseif ($role == Users::ROLE_CONTRIBUTOR) {
			
			foreach($shelterIds as $shelterId) {
				$shelterContributor = new ShelterContributor();
				$shelterContributor->user_id = $user->user_id;
				$shelterContributor->shelter_id = $shelterId;
				$shelterContributor->save();
			}

			foreach($cityIds as $cityId) {
				$cityContributor = new CityContributor();
				$cityContributor->user_id = $user->user_id;
				$cityContributor->city_id = $cityId;
				$cityContributor->save();
			}

		}

		$this->redirect($this->createUrl("user/edit", array(
			'id' => $user->user_id
		)));
	}
}

