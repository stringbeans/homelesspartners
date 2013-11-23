<?php

class CityController extends Controller
{

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
		Yii::app()->clientScript->registerScriptFile('/js/jquery.validate.js', CClientScript::POS_END);

		$cityId = Yii::app()->input->get("id");

		$city = Cities::model()->findByPk($cityId);
		$regions = Region::model()->findAll();

		$this->render("/city/edit/main", array(
			'city' => $city,
			'regions' => $regions
		));
	}

	public function actionSave() 
	{
		$cityId = Yii::app()->input->post("cityId");
		$regionId = Yii::app()->input->post("regionId");
		$name = Yii::app()->input->post("name");
		$enabled = Yii::app()->input->post("enabled", 0);

		$city = new Cities();
		if(!empty($cityId))
		{
			//update
			$city = Cities::model()->findByPk($cityId);
		}
		
		$city->region_id = $regionId;
		$city->name = $name;
		$city->enabled = $enabled;
		
		if($city->save())
		{
			Yii::app()->user->setFlash('success', "Saved");
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

