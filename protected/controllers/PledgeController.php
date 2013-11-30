<?php

class PledgeController extends Controller
{
	public function actionIndex()
	{
		Yii::app()->clientScript->registerScriptFile('/js/list.min.js', CClientScript::POS_END);
		
		$pledges = array();

		$myShelterIds = array();

		if(Yii::app()->user->role == 'shelter')
		{
			//assuming you're the shelter manager...
			//find all the shelters you are coordinating
			$shelterCoordinators = ShelterCoordinators::model()->findAllByAttributes(array(
				'user_id' => Yii::app()->user->id
			));

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

	public function actionDeletePledgeFromSession()
	{
		$giftId = Yii::app()->input->post("giftId");

		if(isset(Yii::app()->session['pledgeCart']))
		{
			$currentPledgeCart = Yii::app()->session['pledgeCart'];

			if((sizeof($currentPledgeCart) == 1) && in_array($giftId, $currentPledgeCart))
			{
				$currentPledgeCart = array();
			}
			elseif(($key = array_search($giftId, $currentPledgeCart)) !== false) {
			    unset($currentPledgeCart[$key]);
			}

			//store in session
			Yii::app()->session['pledgeCart'] = $currentPledgeCart;
		}

		echo json_encode(array('success' => 1));
	}

	public function actionViewCart()
	{
		Yii::app()->clientScript->registerScriptFile('/js/jquery-ui-1.10.3.custom.min.js', CClientScript::POS_END);
		Yii::app()->clientScript->registerScriptFile('/js/jquery.validate.js', CClientScript::POS_END);

		//get all gifts by gift id, grouped by shelter
		$currentPledgeCart = Yii::app()->session['pledgeCart'];
		//Yii::app()->session['pledgeCart'] = array(6359);

		//$currentPledgeCart = array(6359);

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
		$shelterIds = array_keys($deliverDate);
		$data = array(
			'pledgeCount' => 0,
			'shelterCount' => 0,
			'shelters' => array()		// keyed by shelter_id
		);

		/*
			collect all the pledges and create a $data array to pass to the confirmation Email. Format is: 
			array(
				'pledgeCount' => <int>,
				'shelterCount' => <int>,
				'shelters' => array(
					<shelter_id> => array(
						'shelter' => <shelfter_object>,
						'dropoffs' => <array_of_dropoff_objects>,
						'stories' => array(
							<story_id> => array(
								'story' => <story_object>,
								'gifts' => array(
									<gift_object>,
									...
								)
							),
							...
						)
					)
					...
				)
			)

		*/
		foreach($giftIds as $giftId)
		{
			$gift = Gifts::model()->findByPk($giftId);

			if ($gift) {
				$story = Stories::model()->findByPk($gift->story_id);

				if ($story) {
					$shelter = Shelters::model()->findByPk($story->shelter_id);

					if ($shelter) {
						$shelterId = $story->shelter_id;
						$data['pledgeCount']++;

						if (empty($data['shelters'][$shelterId])) {
							$data['shelterCount']++;
							$data['shelters'][$shelterId] = array(
								'shelter' => $shelter,
								'dropoffs' => ShelterDropoffs::model()->findAllByAttributes(array('shelter_id' => $shelterId)),
								'stories' => array()
							);
						}

						if (empty($data['shelters'][$shelterId]['stories'][$gift->story_id])) {
							$data['shelters'][$shelterId]['stories'][$gift->story_id] = array(
								'story' => $story, 
								'gifts' => array()
							);
						}

						$data['shelters'][$shelterId]['stories'][$gift->story_id]['gifts'][] = $gift;
						
						//create a pledge
						$pledge = new Pledges();
						$pledge->gift_id = $giftId;
						$pledge->user_id = Yii::app()->user->id;
						$pledge->status = "pledged";
						$pledge->estimated_delivery_date = date("Y-m-d", strtotime($deliverDate[$story->shelter_id]));
						$pledge->date_created = new CDbExpression('NOW()');
						$pledge->save();

					}

				}

			}
			
		}
		
		if ($this->sendConfirmEmail($data)) {

			//reset session
			unset(Yii::app()->session['pledgeCart']);

			$this->redirect($this->createUrl("pledge/thankYou"));

		} else {
			// WTF Emailed failed (or debug)
		}

	}

	public function actionThankYou()
	{
		$this->render("/pledge/thankYou/main", array(
		));
	}

	protected function sendConfirmEmail($data) 
	{
		$email = "Thank you so very much for your kind and generous gift(s). You never know how an act of kindness, like the one you have shown, will affect others. Maybe that one gift/card can give them the encouragement they need to not only make a difference in their day, but in their life.";
		$email .= "\n\nHere is a copy of your pledge order. Please print this email and bring it with you when dropping off gifts.";


		$email .= "\n\nSUMMARY (Please print for your own records)";
		$email .= "\n\n=====================================";
		$email .= "\n\nTOTAL PLEDGES: ".$data['pledgeCount'];
		$email .=   "\nTOTAL SHELTERS: ".$data['shelterCount'];
		$email .= "\n";

		$shelterIndex = 1;
		foreach ($data['shelters'] as $shelterId => $shelterData) {

			$email .=   "\n=====================================";
			$email .= "\n\nSHELTER ".$shelterIndex.":";

			$shelter = $shelterData['shelter'];
			$dropoffLocations = $shelterData['dropoffs'];

			$email .= "\n\nShelter Name: {$shelter->name}";
			$email .= "\nStreet: {$shelter->street}";
			$email .= "\nPhone: {$shelter->phone}";


			if(!empty($dropoffLocations)) {
				$email .= "\n\nDROP OFF LOCATIONS:";
				$email .=   "\n-------------------";

				foreach($dropoffLocations as $location) {
					$email .= "\nName: {$location->name}";
					$email .= "\nAddress: {$location->address}";
					$email .= "\nNotes: {$location->notes}";
					$email .= "\n";
				}
			}

			$email .= "\n\nPLEDGES:";
			$email .=   "\n-------------------";

			foreach($shelterData['stories'] as $storyData)
			{
				$story = $storyData['story'];
				$gifts = $storyData['gifts'];

				$email .= "\nName: ".$story->fname.$story->lname;
				$email .= "\nID: ".$story->assigned_id;

				foreach ($gifts as $gift) {
					$email .= "\nGift: ".$gift->description;
				}

				$email .= "\n";
			}

			$shelterIndex++;
		}

		$email .=   "\n=====================================";


		$email .= "\n\nIf you are unable to pledge one or more gifts, please email <pledges@homelesspartners.com> or reply to this email.";
		$email .= "\n\nThank you for your pledge,";
		$email .= "\n\n- Homeless Partners";


		//echo nl2br(htmlentities($email));
		//return false;	// debug

		$emailer = new Email();
		$result = $emailer->send(
			Yii::app()->params['HP_SENDER_EMAIL_ADDRESS'], 
			Yii::app()->user->email,
			'Thank you for your pledge!', 
			$email
		);

		// successful email
		return true;
	}
}