<?php

class CityController extends Controller
{

	public function actionCityShelters()
	{

		$this->render("/city/index/cityshelters", array());
	}
	
	public function actionIndex()
	{
		//fetch all cities
		$cities = Cities::model()->findAll();

		$this->render("/city/index/main", array(
			'cities' => $cities
		));
	}
	
	public function actionEdit()
	{
		Yii::app()->clientScript->registerCssFile('/css/selectize.bootstrap3.css');
        Yii::app()->clientScript->registerScriptFile('/js/selectize.min.js', CClientScript::POS_END);
		Yii::app()->clientScript->registerScriptFile('/js/jquery.validate.js', CClientScript::POS_END);

		$cityId = Yii::app()->input->get("id");

		$city = Cities::model()->findByPk($cityId);
		$regions = Region::model()->findAll();

		//get all city coordinators
		$allCityCoordinators = Users::model()->findAllByAttributes(array(
			'role_new' => 'city'
		));

		//get current city coordinators for this specific city
		$currentCityCoordinators = array();
		if(!empty($cityId))
		{
			$cityCoordinators = CityCoordinators::model()->findAllByAttributes(array(
				'city_id' => $cityId
			));

			foreach($cityCoordinators as $c)
			{
				$currentCityCoordinators[] = $c->user_id;
			}
		}

		$this->render("/city/edit/main", array(
			'city' => $city,
			'regions' => $regions,
			'allCityCoordinators' => $allCityCoordinators,
			'currentCityCoordinators' => $currentCityCoordinators
		));
	}

	public function actionSave() 
	{
		$cityId = Yii::app()->input->post("cityId");
		$regionId = Yii::app()->input->post("regionId");
		$name = Yii::app()->input->post("name");
		$enabled = Yii::app()->input->post("enabled", 0);
		$cityCoordinators = Yii::app()->input->post("cityCoordinators", array());
		$imageLinkUrl = Yii::app()->input->post("image_link_url");

		$city = new Cities();
		if(!empty($cityId))
		{
			//update
			$city = Cities::model()->findByPk($cityId);
		}
		
		$city->region_id = $regionId;
		$city->name = $name;
		$city->enabled = $enabled;
		$city->img_link_url = $imageLinkUrl;

		if($city->save())
		{
			Yii::app()->user->setFlash('success', "Saved");

			//handle saving coordinators
			CityCoordinators::model()->deleteAllByAttributes(array(
				'city_id' => $city->city_id
			));
			foreach ($cityCoordinators as $userId)
			{
				$cityCoordinator = new CityCoordinators();
				$cityCoordinator->user_id = $userId;
				$cityCoordinator->city_id = $city->city_id;
				$cityCoordinator->save();
			}

			$uploadDir = dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'city'.DIRECTORY_SEPARATOR;
			$uploadedImage = CUploadedFile::getInstanceByName("image");
			if(!empty($uploadedImage))
			{
				$uploadedImage->saveAs($uploadDir.$uploadedImage->getName());
				$city->img = "/uploads/city/".$uploadedImage->getName();
			}
			
			$city->save();
		}
		else
		{
			Yii::app()->user->setFlash('error', "City wasnt saved!");
		}

		$this->redirect($this->createUrl("city/edit", array(
			'id' => $city->city_id
		)));
	}

	public function actionDelete()
	{
		$cityId = Yii::app()->input->get("id");

		Cities::model()->deleteByPk($cityId);

		Yii::app()->user->setFlash('success', "City Deleted");

		$this->redirect($this->createUrl("city/index"));
	}
}

