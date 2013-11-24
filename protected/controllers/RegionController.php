<?php

class RegionController extends Controller
{

	public function actionIndex()
	{
		//fetch all cities
		$regions = Region::model()->findAll();

		$this->render("/region/index/main", array(
			'region' => $regions
		));
	}
	
	public function actionEdit()
	{
		Yii::app()->clientScript->registerScriptFile('/js/jquery.validate.js', CClientScript::POS_END);

		$regionId = Yii::app()->input->get("id");

		$region = Region::model()->findByPk($regionId);
		$countries = Country::model()->findAll();

		$this->render("/region/edit/main", array(
			'region' => $region,
			'countries' => $countries
		));
	}

public function actionSave() 
	{
		$regionId = Yii::app()->input->post("regionId");
		$countryId = Yii::app()->input->post("countryId");
		$name = Yii::app()->input->post("name");
		//$enabled = Yii::app()->input->post("enabled", 0);
		$region = new Region();
		if(!empty($regionId))
		{
			//update
			$region = Region::model()->findByPk($regionId);
		}
		
		$region->country_id = $countryId;
		$region->name = $name;

		if($region->save())
		{
			Yii::app()->user->setFlash('success', "Saved");
/*
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
			$uploadedImage->saveAs($uploadDir.$uploadedImage->getName());

			$city->img = "/uploads/city/".$uploadedImage->getName();
*/
			$region->save();
		}
		else
		{
			Yii::app()->user->setFlash('error', "Region wasnt saved!");
		}

		$this->redirect($this->createUrl("region/edit", array(
			'id' => $region->region_id
		)));
	}

	public function actionDelete()
	{
		$regionId = Yii::app()->input->get("id");

		Region::model()->deleteByPk($regionId);

		Yii::app()->user->setFlash('success', "Region Deleted");

		$this->redirect($this->createUrl("region/index"));
	}


}

