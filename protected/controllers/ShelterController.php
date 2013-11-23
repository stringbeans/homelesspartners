<?php

class ShelterController extends Controller
{

    public function actionIndex() {
        //fetch all shelters
        $shelters = Shelters::model()->findAll();

        $this->render("/shelter/index/main", array(
            'shelters' => $shelters
        ));
    }

    public function actionEdit() {
        $shelterId = Yii::app()->input->get("id");

        $shelter = Shelters::model()->findByPk($shelterId);

            $this->render("/shelter/edit/main", array(
                'shelter' => $shelter
            ));
    }

    public function actionRemove() {

    }

    public function actionSave() {

    }
}
