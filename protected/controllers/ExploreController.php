<?php

class ExploreController extends Controller
{
    public function actionIndex()
    {
        $cities = array();
        $stories = array();
        $cityResults = Cities::model()->findAll();
        $currentCityId = Yii::app()->input->get('cityId');
        $currentShelterId = Yii::app()->input->get('shelterId');
        $currentCity = null;
        $currentShelter = null;

        foreach($cityResults as $city) {
        	if ($currentCityId && $city->city_id == $currentCityId) {
        		$currentCity = $city;
        	}

        	$shelters = Cities::model()->getSheltersWithTotalPledges($city->city_id);
        	
        	$cityObject = (object) array(
        		'cityInfo' => $city,
        		'shelters' => $shelters
        	);

        	array_push($cities, $cityObject);
        }

        if ($currentShelterId) {
        	// set currentShelter
        }

        $this->render("/explore/index/main", array(
        	'cities' => $cities, 
        	'currentCity' => $currentCity, 
        	'currentShelter' => $currentShelter,
        	'stories' => $stories));
    }

}

?>