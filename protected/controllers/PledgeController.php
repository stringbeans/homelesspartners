<?php

class PledgeController extends Controller
{
	public function actionIndex()
	{
		Yii::app()->clientScript->registerScriptFile('/js/list.min.js', CClientScript::POS_END);
		//assuming you're the shelter manager...
			//find all the shelters you are coordinating
		/*$shelterCoordinators = ShelterCoordinators::model()->findAllByAttributes(array(
			'user_id' => Yii::app()->user->id
		));

		$myShelterIds = array();
		foreach($shelterCoordinators as $shelterCoordinator)
		{
			$myShelterIds[] = $shelterCoordinator->shelter_id;
		}
		*/

		$myShelterIds = array(62);

			//find all pledges that belong to that shelter that aren't confirmed
		
		$undeliveredPledges = array();
		if(!empty($myShelterIds))
		{
			$undeliveredPledges = Pledges::model()->getAllUndeliveredPledgesForShelters($myShelterIds);
		}

		$this->render("/pledge/index/main", array(
			'undeliveredPledges' => $undeliveredPledges
		));
	}

	public function actionSave() 
	{
		
	}

	public function actionDelete()
	{
	}
}

