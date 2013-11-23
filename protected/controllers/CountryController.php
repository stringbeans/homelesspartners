<?php

class CountryController extends Controller
{

	public function actionIndex()
	{
		//fetch all countries
		$countries = Country::model()->findAll();

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
}

