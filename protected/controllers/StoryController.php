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

    private function _getApplicableShelters($userId)
    {
        $shelterIds = array();

        if(Yii::app()->user->role == Users::ROLE_ADMIN)
        {
            $shelters = Shelters::model()->findAll();

            $shelterIds = $this->_createShelterIdList($shelters);
        }
        elseif(Yii::app()->user->role == Users::ROLE_CITY)
        {
            $cityCoordinators = CityCoordinators::model()->findAllByAttributes(array(
                'user_id' => $userId
            ));

            $cityIds = array();
            foreach($cityCoordinators as $cc)
            {
                $cityIds[] = $cc->city_id;
            }

            if(!empty($cityIds))
            {
                $shelters = Shelters::model()->findAll(array(
                    'condition' => 't.city_id in ('.implode(",", $cityIds).')'
                ));

                $shelterIds = $this->_createShelterIdList($shelters);
            }
        }
        elseif(Yii::app()->user->role == Users::ROLE_SHELTER)
        {
            //now get a list of shelters they have access to
            $shelters = ShelterCoordinators::model()->findAllByAttributes(array(
                'user_id' => $userId
            ));

            $shelterIds = $this->_createShelterIdList($shelters);
        }
        elseif(Yii::app()->user->role == Users::ROLE_CONTRIBUTOR)
        {
            $cityContributors = CityContributor::model()->findAllByAttributes(array(
                'user_id' => $userId
            ));

            foreach($cityContributors as $cityContributor)
            {
                $shelters = Shelters::model()->findAllByAttributes(array(
                    'city_id' => $cityContributor->city_id
                ));

                $shelterIds = $this->_createShelterIdList($shelters);
            }

            $shelterContributors = ShelterContributor::model()->findAllByAttributes(array(
                'user_id' => $userId
            ));

            $shelterIds = array_merge($shelterIds, $this->_createShelterIdList($shelterContributors));
            $shelterIds = array_unique($shelterIds);
        }

        return $shelterIds;
    }

    private function _createShelterIdList($shelters = array())
    {
        $shelterIds = array();
        foreach($shelters as $shelter)
        {
            $shelterIds[] = $shelter->shelter_id;
        }

        return $shelterIds;
    }


    // WORK IN PROGRESS.
    // This function needs to be optimized. For now caching some queries to get some speedup. 
    // In conjunction with _getApplicableStories it would be nice to implement this logic
    // straight in the query. 
    // assume shelter exists and is not empty
    private function _canUserEditStory($user, $story)
    {
        $key = 'sc'.$user->id;
        $shelterCoordinators = LocalCache::read($key);
        if (!$shelterCoordinators) {
            $shelterCoordinators = ShelterCoordinators::model()->findAllByAttributes(array('user_id'=>$user->id));
            LocalCache::write($key, $shelterCoordinators);
        }
        $key = 'city'.$story->shelter_id;
        $cid = LocalCache::read($key);
        if (!$cid) {
            if (!empty($story->city_id)) {
                $cid = $story->city_id;
            } else {
                $cid = Shelters::model()->findByPk($story->shelter_id)->city_id;
            }
            LocalCache::write($key, $cid);
        }
        $key = 'cc'.$user->id;
        $cityCoordinators = LocalCache::read($key);
        if (!$cityCoordinators) {
            $cityCoordinators = CityCoordinators::model()->findAllByAttributes(array('user_id'=>$user->id));
            LocalCache::write($key, $cityCoordinators);
        }

                // you're super
        return  $user->role == Users::ROLE_ADMIN ||
                // story belongs to you
                $user->id == $story->creator_id ||
                // story is in your shelter
                $this->_isValueInArray('shelter_id', $story->shelter_id, $shelterCoordinators) ||
                // story is in your city
                $this->_isValueInArray('city_id', $cid, $cityCoordinators)
                ;

                /*

                // you're super
        return  $user->role == Users::ROLE_ADMIN ||
                // story belongs to you
                $user->id == $story->creator_id ||
                // story is in your shelter
                count($shelterCoordinators)>0 ||
                // story is in your city
                count($cityCoordinators)>0
                ;
                */

    }

    // return true if the key/val pair are in the array
    private function _isValueInArray($key, $val, $arr) {
        foreach ($arr as $obj) {
            $obj = (object) $obj;
            if ($obj->$key == $val) {
                return true;
            }
        }
        return false;
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

        //fetch all stories based on logged in userId and shelter_coordinators mapped shelterId
        /*
        $shelterIds = $this->_getApplicableShelters(Yii::app()->user->id);
        $stories = array();
        
        print_r($shelterIds);

        if(!empty($shelterIds))
        {
            $stories = $this->loadStoryList($shelterIds);
        }
        //*/
        
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
            //$this->redirect($this->createUrl("story/index"));
            //return;
            exit;
        }

        $userId = Yii::app()->user->id;

        //now get a list of shelters they have access to
        $shelterIds = $this->_getApplicableShelters(Yii::app()->user->id);

        $selectableShelters = array();
        if(!empty($shelterIds))
        {
            //now get a list of stories where the story is mapped to any of these shelter IDs
            $selectableShelters = Shelters::model()->findAll(array(
                'condition' => '`t`.shelter_id in (' . implode(",", $shelterIds) . ')'
            ));
        }
        else
        {
            $selectableShelters = Shelters::model()->findAll();
        }
        //fget their userId

        $this->render("/story/edit/main", array(
            'story' => $story,
            'gifts' => $gifts,
            'shelters' => $selectableShelters,
            'selectedShelterId' => $selectedShelterId,
            'storyId' => $storyId,
            'userId' => $userId,
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
