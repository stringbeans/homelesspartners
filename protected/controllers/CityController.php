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
		$cityId = Yii::app()->input->post("id");
		$name = Yii::app()->input->post("name");

		$city = new Cities();
		if(!empty($cityId))
		{
			//update
			$city = Cities::model()->findByPk($cityId);
		}
		
		//$city->name = 
	}
}

