<?php

class PledgeController extends Controller
{
	public function actionIndex()
	{
		Yii::app()->clientScript->registerScriptFile('/js/list.min.js', CClientScript::POS_END);
		
		$pledges = array();

		if(Yii::app()->user->role == 'shelter')
		{
			//assuming you're the shelter manager...
			//find all the shelters you are coordinating
			$shelterCoordinators = ShelterCoordinators::model()->findAllByAttributes(array(
				'user_id' => Yii::app()->user->id
			));

			$myShelterIds = array();
			foreach($shelterCoordinators as $shelterCoordinator)
			{
				$myShelterIds[] = $shelterCoordinator->shelter_id;
			}

			//find all pledges that belong to that shelter that aren't confirmed
			
			
			if(!empty($myShelterIds))
			{
				$pledges = Pledges::model()->getAllPledgesForShelters($myShelterIds);
			}
		}
		elseif(Yii::app()->user->role == 'admin')
		{
			$pledges = Pledges::model()->getAllPledgesForShelters($myShelterIds);
		}

		$this->render("/pledge/index/main", array(
			'pledges' => $pledges
		));
	}

	public function actionSetStatus() 
	{
		$pledgeId = Yii::app()->input->get("id");
		$status = Yii::app()->input->get("status");

		$pledge = Pledges::model()->findByPk($pledgeId);
		$pledge->status = $status;
		if($pledge->save())
		{
			Yii::app()->user->setFlash('success', "Pledge updated!");
		}
		else
		{
			Yii::app()->user->setFlash('error', "Pledge status not changed");
		}

		$this->redirect($this->createUrl("pledge/index"));
	}

	public function actionDelete()
	{
		$pledgeId = Yii::app()->input->get("id");

		Pledges::model()->deleteByPk($pledgeId);

		Yii::app()->user->setFlash('success', "Pledge deleted");

		$this->redirect($this->createUrl("pledge/index"));
	}
}

