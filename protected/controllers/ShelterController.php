<?php

class ShelterController extends Controller
{

    public function actionIndex()
    {
        //fetch all shelters
        $shelters = Shelters::model()->findAll();

        $this->render("/shelter/index/main", array('shelters' => $shelters));
    }

    public function actionEdit()
    {
        $shelterId = Yii::app()->input->get("id");

        $shelter = Shelters::model()->findByPk($shelterId);
        $cities = Cities::model()->findAll();

 //TODO       //this will be the logged in user's ID
        $userId = 18;

        $this->render("/shelter/edit/main", array(
            'shelter' => $shelter,
            'cities' => $cities,
            'userId' => $userId
        ));
    }

    public function actionRemove()
    {

    }

    public function actionSave()
    {

    }

}
