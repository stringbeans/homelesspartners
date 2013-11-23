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

    public function actionDelete()
    {
        $shelterId = Yii::app()->input->get("id");

        Shelters::model()->deleteByPk($shelterId);

        Yii::app()->user->setFlash('success', "Shelter Deleted");

        $this->redirect($this->createUrl("shelter/index"));
    }

    public function actionSave()
    {
        $shelterId = Yii::app()->input->post("shelterId");
        $cityId = Yii::app()->input->post("cityId");
        $creatorId = Yii::app()->input->post("creatorId");
        $name = Yii::app()->input->post("name");
        $street = Yii::app()->input->post("street");
        $phone = Yii::app()->input->post("phone");
        $they_do = Yii::app()->input->post("they_do");
        $they_need = Yii::app()->input->post("they_need");
        $dropoff_details = Yii::app()->input->post("dropoff_details");
        $ID_FORMAT = Yii::app()->input->post("ID_FORMAT");
        $website = Yii::app()->input->post("website");
        $email = Yii::app()->input->post("email");
        $mapped = Yii::app()->input->post("mapped", 0);
        $enabled = Yii::app()->input->post("enabled", 0);

        $shelter = new Shelters();
        if(!empty($shelterId))
        {
            //update
            $shelter = Shelters::model()->findByPk($shelterId);
        } else {
            $shelter->date_created = new CDbExpression('NOW()');
        }

        $shelter->city_id = $cityId;
        $shelter->creator_id = $creatorId;
        $shelter->name = $name;
        $shelter->street = $street;
        $shelter->phone = $phone;
        $shelter->they_do = $they_do;
        $shelter->they_need = $they_need;
        $shelter->dropoff_details = $dropoff_details;
        $shelter->ID_FORMAT = $ID_FORMAT;
        $shelter->website = $website;
        $shelter->email = $email;
        $shelter->mapped = $mapped;
        $shelter->enabled = $enabled;

        if($shelter->save())
        {
            Yii::app()->user->setFlash('success', "Saved");

        }
        else
        {
            Yii::app()->user->setFlash('error', "Shelter wasnt saved!");

        }

        $this->redirect($this->createUrl("shelter/edit", array(
            'id' => $shelter->shelter_id
        )));
    }


}
