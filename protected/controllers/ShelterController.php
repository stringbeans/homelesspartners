<?php

class ShelterController extends Controller
{

    public function actionShelterStories()
    {

        $this->render("/shelter/index/shelterstories", array());
    }

    public function actionIndex()
    {
 //TODO - currently, this fetches all shelters for a super admin
 //to filter the list for a specific shelters coordinator, call
 //the 'getAccessibleIDs' method for a pruned list of allowable
 //shelters branched in from the sheltercoordinators table
        //fetch all shelters
        $shelters = Shelters::model()->findAll();

        $this->render("/shelter/index/main", array('shelters' => $shelters));
    }

//TODO - this is a placeholder method to be called once we know whether
//we are dealing with a super user (no need to call this) or a shelter
//coordinator (requires this filtering method)
    /**
     * retrieves a list of shelter ids that a user has access to. This is determined
     * by the ShelterCoordinators table as a many to many
     */
    private function getAccessibleShelterIDs($userId) {
        $shelters = ShelterCoordinators::model()->findAllByAttributes(array(
            'user_id' => $userId
        ));

        $idList = array();

        foreach($shelters as $shelter) {
            $idList[] = ', ' . $shelter->shelter_id;
        }
        if(count($idList) == 0) {
            //good spot to throw an error and present a warning - this person is
            //not assigned to any shelters and should not be accessing here
            return array();
        }

        //trim the prefixing comma (is prefixing a real word?)
        return substr($idList,1);
    }

    public function actionEdit()
    {
        Yii::app()->clientScript->registerCssFile('/css/selectize.bootstrap3.css');
        Yii::app()->clientScript->registerScriptFile('/js/selectize.min.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile('/js/jquery.validate.js', CClientScript::POS_END);

        $shelterId = Yii::app()->input->get("id");
        $shelter = Shelters::model()->findByPk($shelterId);
        $cities = Cities::model()->findAll();

        $userId = Yii::app()->user->getId();

        //get all shelter coordinators
        $allShelterCoordinators = Users::model()->findAllByAttributes(array('role' => 'shelter'));

        $this->render("/shelter/edit/main", array(
            'shelter' => $shelter,
            'cities' => $cities,
            'userId' => $userId,
            'allShelterCoordinators' => $allShelterCoordinators,
            'currentShelterCoordinators' => $this->getCurrentShelterCoordinators($shelterId),
            'currentDropoffLocations' => $this->getCurrentDropoffLocations($shelterId)
        ));
    }

    /**
     * retrieves a list of shelter coordinators
     *
     * @param int shelterId
     */
    private function getCurrentShelterCoordinators($shelterId)
    {
        if (empty($shelterId)) {
            return array();
        }

        //get current city coordinators for this specific city
        $currentShelterCoordinators = array();
        if (!empty($shelterId)) {
            $shelterCoordinators = ShelterCoordinators::model()->findAllByAttributes(array('shelter_id' => $shelterId));

            foreach ($shelterCoordinators as $sc) {
                $currentShelterCoordinators[] = $sc->user_id;
            }
        }
        return $currentShelterCoordinators;
    }

    /**
     * retrieves list of currently selected locations for dropoff
     *
     * @param int shelterId
     */
    private function getCurrentDropoffLocations($shelterId)
    {
        if (empty($shelterId)) {
            return array();
        }
        $currentDropoffLocations = array();

        $dropoffLocations = ShelterDropoffs::model()->findAllByAttributes(array('shelter_id' => $shelterId));

        foreach ($dropoffLocations as $location) {
            $currentDropoffLocations[] = array(
                'id' => $location->dropoff_id,
                'name' => $location->name,
                'address' => $location->address
            );
        }

        return $currentDropoffLocations;
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
        $bio = Yii::app()->input->post("bio");
        $dropoff_details = Yii::app()->input->post("dropoff_details");
        $ID_FORMAT = Yii::app()->input->post("ID_FORMAT");
        $website = Yii::app()->input->post("website");
        $email = Yii::app()->input->post("email");
        $mapped = Yii::app()->input->post("mapped", 0);
        $enabled = Yii::app()->input->post("enabled", 0);

        $shelter = new Shelters();
        if (!empty($shelterId)) {
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
        $shelter->bio = $bio;
        $shelter->dropoff_details = $dropoff_details;
        $shelter->ID_FORMAT = $ID_FORMAT;
        $shelter->website = $website;
        $shelter->email = $email;
        $shelter->mapped = $mapped;
        $shelter->enabled = $enabled;
        $shelterCoordinators = Yii::app()->input->post("shelterCoordinators", array());

        if($shelter->save())
        {
            //handle saving coordinators
            ShelterCoordinators::model()->deleteAllByAttributes(array('shelter_id' => $shelter->shelter_id));

            foreach ($shelterCoordinators as $userId) {
                $shelterCoordinator = new ShelterCoordinators();
                $shelterCoordinator->user_id = $userId;
                $shelterCoordinator->shelter_id = $shelter->shelter_id;
                $shelterCoordinator->save();
            }

            $uploadDir = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'shelter' . DIRECTORY_SEPARATOR;
            $uploadedImage = CUploadedFile::getInstanceByName("image");

            if (is_object($uploadedImage)) {
                $uploadedImage->saveAs($uploadDir . $uploadedImage->getName());
                $shelter->img = "/uploads/shelter/" . $uploadedImage->getName();
            }

            $shelter->save();
            $this->pruneRemovedDropoffLocations($shelter->shelter_id);
            $this->saveNewDropoffLocation($shelter->shelter_id);

            Yii::app()->user->setFlash('success', "Saved");

        } else {
            Yii::app()->user->setFlash('error', "Shelter wasnt saved!");
        }

        $this->redirect($this->createUrl("shelter/edit", array('id' => $shelter->shelter_id)));
    }

    /**
     * removes any dropoff locations from the database that have been
     * removed from the list within the GUI
     *
     * @param int shelterId
     */
    private function pruneRemovedDropoffLocations($shelterId)
    {

        $currentDropoffLocations = Yii::app()->input->post("dropoffLocations", array());

        $existingLocations = ShelterDropoffs::model()->findAllByAttributes(array('shelter_id' => $shelterId));
        $existingLocationIds = array();

        foreach ($existingLocations as $location) {
            $existingLocationIds[] = $location->dropoff_id;
        }

        foreach ($existingLocationIds as $locationId) {

            if (!in_array($locationId, $currentDropoffLocations)) {
                ShelterDropoffs::model()->deleteAllByAttributes(array('dropoff_id' => $locationId));
            }
        }
    }

    /**
     * saves any new dropoff locations entered in the spare fields
     *
     * @param int shelterId
     */
    private function saveNewDropoffLocation($shelterId)
    {

        $dropoffName = Yii::app()->input->post("location-name");
        if (strlen($dropoffName) == 0) {
            return;
        }
        $dropoffAddress = Yii::app()->input->post("location-address");
        $dropoffNotes = Yii::app()->input->post("location-notes");

        $location = new ShelterDropoffs();

        $location->shelter_id = $shelterId;
        $location->name = $dropoffName;
        $location->address = $dropoffAddress;
        $location->notes = $dropoffNotes;

        $location->save();

    }

    public function actionMigrateIntoBio()
    {
        $shelters = Shelters::model()->findAll();

        foreach($shelters as $shelter)
        {
            if (!empty($shelter->they_do) && !empty($shelter->they_need))
            {
                $shelter->bio = $shelter->they_do . "\n" . $shelter->they_need;
            }
            elseif (!empty($shelter->they_do))
            {
                $shelter->bio = $shelter->they_do;
            }
            else {
                $shelter->bio = $shelter->they_need;
            }
            $shelter->save();
        }
    }
}
