<?php


class StoryController extends Controller
{
    private $cache = array();

    public function actionStory()
    {
        $storyid = Yii::app()->input->get("id");
        $stories = Stories::model()->getStorySummarybyID($storyid);

        $gifts = Gifts::model()->findAllByStoryIdWithPledgeCount($storyid);

        $currentPledgeCart = array();
        if(isset(Yii::app()->session['pledgeCart']))
        {
            $currentPledgeCart = Yii::app()->session['pledgeCart'];
        }

        $this->render("/story/index/story", array(
            'stories' => $stories,
            'currentPledgeCart' => $currentPledgeCart,
            'gifts' => $gifts

        ));
    }

    // assume story exists and is not empty
    private function _canUserEditStory($user, $story)
    {
                // you're super
        return  $user->role == Users::ROLE_ADMIN ||
                // story belongs to you
                $user->id == $story->creator_id ||
                // story is in your shelter
                Helpers::isValueInArray('shelter_id', $story->shelter_id, ShelterCoordinators::model()->findAllByUserId($user->id)) ||
                // story is in your city
                Helpers::isValueInArray('city_id', 
                    !empty($story->city_id) ? $story->city_id : Shelters::model()->getCityIdByShelterId($story->shelter_id), 
                    CityCoordinators::model()->findAllByUserId($user->id)
                );
    }

    private function _getApplicableShelters() 
    {
        $user = Yii::app()->user;

        $shelters = array();
        if ($user->role == Users::ROLE_ADMIN) {
            $shelters = Shelters::model()->findAll();
        } else if ($user->role == Users::ROLE_CITY) {
            $cityIds = Helpers::extractFromArray('city_id', CityCoordinators::model()->findAllByUserId($user->id));
            $shelters = Shelters::model()->findAllByAttributes(array('city_id'=>$cityIds));
        } else if ($user->role == Users::ROLE_SHELTER) {
            $shelterIds = Helpers::extractFromArray('shelter_id', ShelterCoordinators::model()->findAllByUserId($user->id));
            $shelters = Shelters::model()->findAllByAttributes(array('shelter_id'=>$shelterIds));
        } else if ($user->role == Users::ROLE_CONTRIBUTOR) {
            $cityIds = Helpers::extractFromArray('city_id', CityContributor::model()->findAllByUserId($user->id));
            $shelterIds = Helpers::extractFromArray('shelter_id', ShelterContributor::model()->findAllByUserId($user->id));
            $criteria = new CDbCriteria;
            $criteria->addInCondition('city_id', $cityIds, 'OR');
            $criteria->addInCondition('shelter_id', $shelterIds, 'OR');
            $shelters = Shelters::model()->findAll($criteria);
        }

        return $shelters;
    }

    private function _getApplicableStories() {
        //$stories = Stories::model()->findAll();
        $query = 'select 
        stories.story_id, stories.creator_id, stories.shelter_id, fname, lname, cities.name as city, cities.city_id, shelters.name as `shelter`, users.`email`, stories.assigned_id
        from stories
        left join shelters on shelters.`shelter_id` = stories.`shelter_id`
        left join cities on cities.city_id = shelters.`city_id`
        left join users on users.`user_id` = stories.`creator_id`';
        $connection = Yii::app()->db;
        $command = $connection->createCommand($query);
        $stories = $command->queryAll();


        $allowedStories = array();
        $user = Yii::app()->user;
        foreach ($stories as $story) {
            if ($this->_canUserEditStory($user, (object)$story)) {
                $allowedStories[] = $story;
            }
        }

        return $allowedStories;
        //var_dump($stories);
    }

    public function actionIndex()
    {
        Yii::app()->clientScript->registerScriptFile('/js/list.min.js', CClientScript::POS_END);

        $t1 = microtime(true);
        $stories = $this->_getApplicableStories();

        $tdiff = microtime(true) - $t1;
        //echo $tdiff.'s';

        $this->render("/story/index/main", array('stories' => $stories));
    }

    public function actionEdit()
    {
        Yii::app()->clientScript->registerCssFile('/css/selectize.bootstrap3.css');
        Yii::app()->clientScript->registerScriptFile('/js/selectize.min.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile('/js/jquery.validate.js', CClientScript::POS_END);

        $storyId = Yii::app()->input->get("id");
        $selectedShelterId = Yii::app()->input->get("shelterId");
        $story = Stories::model()->findByPk($storyId);
        $gifts = Gifts::model()->findAllByAttributes(array(
            'story_id' => $storyId
        ));


        if(!empty($story) && !$this->_canUserEditStory(Yii::app()->user, $story))
        {
            Yii::app()->user->setFlash('error', "You don't have permission to edit this story");
            $this->redirect($this->createUrl("story/index"));
            return;
        }

        $selectableShelters = $this->_getApplicableShelters();


        $this->render("/story/edit/main", array(
            'story' => $story,
            'gifts' => $gifts,
            'shelters' => $selectableShelters,
            'selectedShelterId' => $selectedShelterId,
            'storyId' => $storyId,
            'userId' => Yii::app()->user->id,
            'currentGiftRequests' => $this->getCurrentGiftRequest($storyId)
        ));
    }


    /**
     * retrieves list of currently selected locations for dropoff
     *
     * @param int shelterId
     */
    private function getCurrentGiftRequest($storyId)
    {
        if (empty($storyId)) {
            return array();
        }
        $currentGiftRequests = array();

        $gifts = Gifts::model()->findAllByAttributes(array('story_id' => $storyId));

        foreach ($gifts as $gift) {
            $currentGiftRequests[] = array(
                'id' => $gift->gift_id,
                'description' => $gift->description
            );
        }

        return $currentGiftRequests;
    }


    public function actionDelete()
    {
        $storyId = Yii::app()->input->get("id");

        $story = Stories::model()->findByPk($storyId);
        
        if(!empty($story) && !$this->_canUserEditStory(Yii::app()->user, $story))
        {
            Yii::app()->user->setFlash('error', "You don't have permission to Delete this story");
        }
        else 
        {
            Stories::model()->deleteByPk($storyId);
            Yii::app()->user->setFlash('success', "Story Deleted");
        }

        $this->redirect($this->createUrl("story/index"));
    }

    public function actionSave()
    {

        $storyId = Yii::app()->input->post("storyId");
        $shelterId = Yii::app()->input->post("shelterId");
        $creatorId = Yii::app()->input->post("creatorId");
        $fname = Yii::app()->input->post("fname");
        $lname = Yii::app()->input->post("lname");
        $gender = Yii::app()->input->post("gender");
        $assigned_id = Yii::app()->input->post("assignedId");
        $storyToTell = Yii::app()->input->post("story");
        $display_order = Yii::app()->input->post("displayOrder");
        $enabled = Yii::app()->input->post("enabled", 0);
        $addNew = ('' != Yii::app()->input->post("saveNewButton"));

        $giftDescriptions = Yii::app()->input->post("gifts", array());
        $giftsToDelete = Yii::app()->input->post("giftsToDelete");

        $giftIdsToDeleteArray = array();
        if(!empty($giftsToDelete))
        {
            $giftIdsToDeleteArray = json_decode($giftsToDelete);
        }

        $story = new Stories();
        if(!empty($storyId))
        {
            //update
            $story = Stories::model()->findByPk($storyId);
        } else {
            $story->date_created = new CDbExpression('NOW()');
        }

        $story->creator_id = $creatorId;
        $story->shelter_id = $shelterId;
        $story->fname = $fname;
        $story->lname = $lname;
        $story->assigned_id = $assigned_id;
        $story->gender = $gender;
        $story->story = $storyToTell;
        $story->display_order = $display_order;
        $story->enabled = $enabled;

        if($story->save())
        {

            //$this->pruneRemovedGiftRequests($story->story_id);
            //$this->saveNewGiftRequest($story->story_id);

            if(!empty($giftIdsToDeleteArray))
            {
                foreach($giftIdsToDeleteArray as $giftId)
                {
                    Gifts::model()->deleteByPk($giftId);
                }
            }

            foreach($giftDescriptions as $description)
            {
                $gift = new Gifts();
                $gift->story_id = $story->story_id;
                $gift->description = $description;
                $gift->date_created = new CDbExpression('NOW()');
                $gift->enabled = 1;
                $gift->save();
            }

            Yii::app()->user->setFlash('success', "Saved");
        }
        else
        {

            Yii::app()->user->setFlash('error', "Shelter wasnt saved!");
        }

        $redirectParams = array(
            'id' => $story->story_id
        );
        if($addNew)
        {
            $redirectParams = array(
                'id' => 0,
                'shelterId' => $shelterId
            );
        }

        $this->redirect($this->createUrl("story/edit", $redirectParams));
    }


    /**
     * removes any requested gifts from the database that have been
     * removed from the list within the GUI
     *
     * @param int storyId
     */
    private function pruneRemovedGiftRequests($storyId)
    {

        $currentGiftRequests = Yii::app()->input->post("giftRequests", array());

        $existingGiftRequests = Gifts::model()->findAllByAttributes(array('story_id' => $storyId));
        $existingGiftIds = array();

        foreach ($existingGiftRequests as $giftRequest) {
            $existingGiftIds[] = $giftRequest->gift_id;
        }

        foreach ($existingGiftIds as $giftId) {

            if (!in_array($giftId, $currentGiftRequests)) {
                Gifts::model()->deleteAllByAttributes(array('gift_id' => $giftId));
            }
        }
    }

    /**
     * saves any new requests entered in the spare fields
     *
     * @param int storyId
     */
    private function saveNewGiftRequest($storyId)
    {

        $description = Yii::app()->input->post("gift_description");
        if (strlen($description) == 0) {
            return;
        }

        $gift = new Gifts();

        $gift->story_id = $storyId;
        $gift->description = $description;
        $gift->date_created = new CDbExpression('NOW()');

        $gift->save();

    }

    private function loadStoryList($shelterIds) {

     $query = 'select 
            stories.story_id, stories.creator_id, fname, lname, cities.name as city, shelters.name as `shelter`, users.`email`, stories.assigned_id
        from stories
        left join shelters on shelters.`shelter_id` = stories.`shelter_id`
        left join cities on cities.city_id = shelters.`city_id`
        left join users on users.`user_id` = stories.`creator_id`
        where shelters.shelter_id in (' . implode(", ", $shelterIds) . ')';

        $connection = Yii::app()->db;
        $command = $connection->createCommand($query);

        return $command->queryAll();
    }
}
