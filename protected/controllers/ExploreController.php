<?php

class ExploreController extends Controller
{
    public function actionIndex()
    {
        //fetch all shelters
          $shelters = Shelters::model()->getShelterCountbyCity();

        $this->render("/explore/index/main", array('shelters' => $shelters));
    }

}
