<?php

class CountryController extends Controller
{

	public function actionIndex()
	{
		//fetch all countries
		//$countries = Country::model()->findAll();
		$countries = Country::model()->getCountrySummary();

		$this->render("/country/index/main", array(
			'countries' => $countries
		));
	}
	
	public function actionEdit()
	{
			
		$countryId = Yii::app()->input->get("id");

		$country = Country::model()->findByPk($countryId);

			$this->render("/country/edit/main", array(
				'country' => $country
			));
	}

	public function actionSave() 
	{
		$countryId = Yii::app()->input->post("countryId");
		$name = Yii::app()->input->post("name");
		//$enabled = Yii::app()->input->post("enabled", 0);
		$country = new Country();
		if(!empty($countryId))
		{
			//update
			$country = Country::model()->findByPk($countryId);
		}
		
		//$country->country_id = $countryId;
		$country->name = $name;

		if($country->save())
		{
			Yii::app()->user->setFlash('success', "Saved");
			$country->save();
		}
		else
		{
			Yii::app()->user->setFlash('error', "Country wasnt saved!");
		}

		$this->redirect($this->createUrl("country/edit", array(
			'id' => $country->country_id
		)));
	}

	public function actionDelete()
	{
		$countryId = Yii::app()->input->get("id");

		Country::model()->deleteByPk($countryId);

		Yii::app()->user->setFlash('success', "Country Deleted");

		$this->redirect($this->createUrl("country/index"));
	}
}

