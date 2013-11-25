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
			Users::ROLE_SHELTER => 'Shelter Coordinator',
			Users::ROLE_CONTRIBUTOR => 'Contributor',
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

		$cities = Cities::model()->findAll();

		$selectedCitiesLookup = array();
		if(isset($user) && $user->role == Users::ROLE_CITY)
		{
			$selectedCities = CityCoordinators::model()->findAllByAttributes(array('user_id' => $userId));
			
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

		$roles = array(
			Users::ROLE_ADMIN => 'Administrator',
			Users::ROLE_CITY => 'City Coordinator',
			Users::ROLE_SHELTER => 'Shelter Coordinator',
			Users::ROLE_CONTRIBUTOR => 'Contributor',
			Users::ROLE_USER => 'User',
		);

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
		$role = Yii::app()->input->post("role");
		$cityIds = Yii::app()->input->post("cityIds", array());
		$shelterIds = Yii::app()->input->post("shelterIds", array());

		$validEmail = filter_var($email, FILTER_VALIDATE_EMAIL);

		if ($validEmail === false) {
			Yii::app()->user->setFlash('error', "The email '" . $email . "' is not valid.");
			$this->redirect($this->createUrl("user/edit", array(
				'id' => $userId
			)));
		}

		if (!empty($userId)) {
			$user = Users::model()->findByPk($userId);
			if (!empty($password))
			{
				$user->pw = $password;
			}
			$user->role = $role;
			$user->save();

			CityCoordinators::model()->deleteAllByAttributes(array('user_id' => $userId));
			ShelterCoordinators::model()->deleteAllByAttributes(array('user_id' => $userId));
		}
		else {
			$user = Users::model()->create($email, $password, $role);
		}

		if ($role == Users::ROLE_CITY) {
			foreach($cityIds as $cityId) {
				CityCoordinators::model()->create($cityId, $user->user_id);
			}
		} elseif ($role == Users::ROLE_SHELTER) {
			foreach($shelterIds as $shelterId) {
				ShelterCoordinators::model()->create($shelterId, $user->user_id);
			}
		}

		Yii::app()->user->setFlash('success', "Saved");

		$this->redirect($this->createUrl("user/edit", array(
			'id' => $user->user_id
		)));
	}
}

