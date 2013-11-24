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

	public function actionAddPledge()
	{
		$giftId = Yii::app()->input->post("giftId");

		$currentPledgeCart = Yii::app()->session['pledgeCart'];

		$currentPledgeCart[] = $giftId;

		$currentPledgeCart = array_unique($currentPledgeCart);

		//store in session
		Yii::app()->session['pledgeCart'] = $currentPledgeCart;

		echo json_encode(array('success' => 1));
	}

	public function actionViewCart()
	{
		Yii::app()->clientScript->registerScriptFile('/js/jquery-ui-1.10.3.custom.min.js', CClientScript::POS_END);
		Yii::app()->clientScript->registerScriptFile('/js/jquery.validate.js', CClientScript::POS_END);

		//get all gifts by gift id, grouped by shelter
		$currentPledgeCart = Yii::app()->session['pledgeCart'];

		$pledgeCartInfo = array();

		$totalGifts = 0;

		if(!empty($currentPledgeCart))
		{
			$gifts = Gifts::model()->getByIds($currentPledgeCart);

			foreach($gifts as $gift)
			{
				$totalGifts++;
				if(isset($pledgeCartInfo[$gift['shelter_id']]))
				{
					$pledgeCartInfo[$gift['shelter_id']]['giftCount']++;

					if(isset($pledgeCartInfo[$gift['shelter_id']]['stories'][$gift['story_id']]))
					{
						$pledgeCartInfo[$gift['shelter_id']]['stories'][$gift['story_id']]['gifts'][] = array(
							'giftId' => $gift['gift_id'],
							'description' => $gift['description'],
						);
					}
					else
					{
						$pledgeCartInfo[$gift['shelter_id']]['stories'][$gift['story_id']] = array(
							'storyId' => $gift['story_id'],
							'fname' => $gift['fname'],
							'lname' => $gift['lname'],
							'assignedId' => $gift['assigned_id'],
							'gifts' => array()
						);

						$pledgeCartInfo[$gift['shelter_id']]['stories'][$gift['story_id']]['gifts'][] = array(
							'giftId' => $gift['gift_id'],
							'description' => $gift['description'],
						);
					}
				}
				else
				{
					$pledgeCartInfo[$gift['shelter_id']] = array(
						'shelter_image' => $gift['shelter_image'],
						'name' => $gift['shelterName'],
						'city' => $gift['cityName'],
						'region' => $gift['regionName'],
						'website' => $gift['website'],
						'giftCount' => 1,
						'dropoffLocations' => array(),
						'stories' => array()
					);

					$pledgeCartInfo[$gift['shelter_id']]['stories'][$gift['story_id']] = array(
						'storyId' => $gift['story_id'],
						'fname' => $gift['fname'],
						'lname' => $gift['lname'],
						'assignedId' => $gift['assigned_id'],
						'gifts' => array()
					);

					$pledgeCartInfo[$gift['shelter_id']]['stories'][$gift['story_id']]['gifts'][] = array(
						'giftId' => $gift['gift_id'],
						'description' => $gift['description'],
					);

					//handle dropoff locations
					$dropoffLocations = ShelterDropoffs::model()->findAllByAttributes(array(
						'shelter_id' => $gift['shelter_id']
					));

					$pledgeCartInfo[$gift['shelter_id']]['dropoffLocations'] = $dropoffLocations;
				}
			}
		}

		$this->render("/pledge/viewCart/main", array(
			'pledgeCartInfo' => $pledgeCartInfo,
			'totalGifts' => $totalGifts
		));
	}

	public function actionConfirmPledges()
	{
		$giftIds = Yii::app()->input->post("giftId", array()); //array of gift ids we're pledging
		$deliverDate = Yii::app()->input->post("deliveryDate", array()); //indexed by shelterid
		
		foreach($giftIds as $giftId)
		{
			$gift = Gifts::model()->findByPk($giftId);
			$story = Stories::model()->findByPk($gift->story_id);

			//create a pledge
			$pledge = new Pledges();
			$pledge->gift_id = $giftId;
			$pledge->user_id = Yii::app()->user->id;
			$pledge->status = "pledged";
			$pledge->estimated_delivery_date = date("Y-m-d", strtotime($deliverDate[$story->shelter_id]));
			$pledge->date_created = new CDbExpression('NOW()');
			$pledge->save();
		}

		//TODO:
		//send email?

		//reset session
		unset(Yii::app()->session['pledgeCart']);

		$this->redirect($this->createUrl("pledge/thankYou"));
	}

	public function actionThankYou()
	{
		$this->render("/pledge/thankYou/main", array(
		));
	}
}