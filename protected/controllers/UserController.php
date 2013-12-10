<?php

class UserController extends Controller
{

	public function actionIndex()
	{
		//$users = Users::model()->findAll(array('order' => 'CONCAT(role) ASC'));
		$users = $this->_getEditableUsers();

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
		
        if(!empty($user) && !$this->_canUserEditUser(Yii::app()->user, $user))
        {
            Yii::app()->user->setFlash('error', "You don't have permission to edit this user");
            $this->redirect($this->createUrl("user/index"));
            return;
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
				Users::ROLE_CITY => 'City Coordinator',
				Users::ROLE_SHELTER => 'Shelter Manager',
				Users::ROLE_CONTRIBUTOR => 'Typist',
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

	// return a list of users the current user has access to
	private function _getEditableUsers() {
		// if admin you get everybody
		// if city you get 
		//		city users who manage cities you manage
		//		shelter users who are in one of your cities
		//		contributers who are in one of your cities
		//		all unassigned users
		// if shelter you get no one
		// if contributer/typist you get no one

        $user = Yii::app()->user;
		$allowedUsers = array();
		$allUsers = Users::model()->findAll(array('order' => 'CONCAT(role) ASC'));


        if ($user->role == Users::ROLE_ADMIN) {
        	$allowedUsers = $allUsers;
        } else if ($user->role == Users::ROLE_CITY) {
			foreach ($allUsers as $otherUser) {
				if ($this->_canCityUserEditUser($user, (object)$otherUser)) {
					$allowedUsers[] = $otherUser;
				}
			}

        } else {
        	// if I'm a shelter, typist or user, then NO ACCESS
        }

		return $allowedUsers;
	}

	private function _canUserEditUser($user, $otherUser) {
		return $user->role == Users::ROLE_ADMIN ||
				$user->id == $otherUser->user_id ||
				($user->role == Users::ROLE_CITY && $this->_canCityUserEditUser($user, $otherUser));
	}

	// keep in mind that $cityUser is a CWebUser (from Auth) and $otherUser is a User model object.
	// the ids are accessed by $cityUser->id, $otherUser->user_id respectively.
	private function _canCityUserEditUser($cityUser, $otherUser) {
		$valid = false;
		if ($otherUser->role == Users::ROLE_USER) {
			$valid = true;
		} else if ($otherUser->role == Users::ROLE_CITY) {
			// these calls are cached, so don't worry too much about calling them in a loop
			$a = CityCoordinators::model()->findAllByUserId($cityUser->id);
			$b = CityCoordinators::model()->findAllByUserId($otherUser->user_id);
			$common = array_intersect(Helpers::extractFromArray('city_id', $a), Helpers::extractFromArray('city_id', $b));

			// valid if other city user manages city that I manage.
			$valid = !empty($common);
		} else if ($otherUser->role == Users::ROLE_SHELTER) {
			// my cities
			$cityIds = Helpers::extractFromArray('city_id', CityCoordinators::model()->findAllByUserId($cityUser->id));

			// shelters that the other user manages
			$shelterIds = Helpers::extractFromArray('shelter_id', ShelterCoordinators::model()->findAllByUserId($otherUser->user_id));

			if (!empty($shelterIds)) {
				$shelters = Shelters::model()->findAllByPk($shelterIds);

				// cities that those shelters belong to			
				$shelterCityIds = Helpers::extractFromArray('city_id', $shelters);

				$common = array_intersect($cityIds, $shelterCityIds);

				// valid if the other shelter manager manages a shelter in a city that I manage.
				$valid = !empty($common);			
			}

		} else if ($otherUser->role == Users::ROLE_CONTRIBUTOR) {
			// my cities
			$cityIds = Helpers::extractFromArray('city_id', CityCoordinators::model()->findAllByUserId($cityUser->id));

			// cities that other user contributes to
			$cityContribIds = Helpers::extractFromArray('city_id', CityContributor::model()->findAllByUserId($otherUser->user_id));

			$common = array_intersect($cityIds, $cityContribIds);

			// other user contributes to cities that I manage
			$valid = !empty($common);

			if (!$valid) {
				// lets check to see if the other user contributes to shelters that are in cities that I manage.

				$shelterContribIds = Helpers::extractFromArray('shelter_id', ShelterContributor::model()->findAllByUserId($otherUser->user_id));	
				if (!empty($shelterContribIds)) {
					$shelters = Shelters::model()->findAllByPk($shelterContribIds);	

					// cities that those shelters belong to			
					$shelterCityIds = Helpers::extractFromArray('city_id', $shelters);

					$common = array_intersect($cityIds, $shelterCityIds);

					// valid if the typis contributes to a shelter in a city that I manage.
					$valid = !empty($common);			
				}
			}
		}

		return $valid;
	}	
}

