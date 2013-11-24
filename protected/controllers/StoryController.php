<?php


class StoryController extends Controller
{

    public function actionIndex()
    {
        //fetch all stories based on logged in userId and shelter_coordinators mapped shelterId

        //first get their userId
 //TODO put something in as a place holder
        $userId = 4437;

        //now get a list of shelters they have access to
        $shelters = ShelterCoordinators::model()->findAllByAttributes(array(
            'user_id' => $userId
        ));

        //trim the shelter IDs into a commma separated list for the next query
        $idList = '';
        foreach($shelters as $shelter) {
            $idList .= ', "' . $shelter->shelter_id . '"';
        }

        //now get a list of stories where the story is mapped to any of these shelter IDs
        $stories = Stories::model()->findAll(array(
            'condition' => '`t`.shelter_id in (' . substr($idList, 1) . ')'
        ));


        $this->render("/story/index/main", array('stories' => $stories));
    }

    public function actionEdit()
    {
        Yii::app()->clientScript->registerCssFile('/css/selectize.bootstrap3.css');
        Yii::app()->clientScript->registerScriptFile('/js/selectize.min.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile('/js/jquery.validate.js', CClientScript::POS_END);

        $storyId = Yii::app()->input->get("id");
        $story = Stories::model()->findByPk($storyId);
        $shelters = Shelters::model()->findAll();
//TODO  this ia a hard coded userId during development, determined by logged in user
        $userId = 4437;

        //now get a list of shelters they have access to
        $shelters = ShelterCoordinators::model()->findAllByAttributes(array(
            'user_id' => $userId
        ));

        //trim the shelter IDs into a commma separated list for the next query
        $idList = '';
        foreach($shelters as $shelter) {
            $idList .= ', "' . $shelter->shelter_id . '"';
        }

        //now get a list of stories where the story is mapped to any of these shelter IDs
        $selectableShelters = Shelters::model()->findAll(array(
            'condition' => '`t`.shelter_id in (' . substr($idList, 1) . ')'
        ));
        //fget their userId
 //TODO put something in as a place holder
        $userId = 4437;

        $this->render("/story/edit/main", array(
            'story' => $story,
            'shelters' => $selectableShelters,
            'storyId' => $storyId,
            'userId' => $userId
        ));
    }

    public function actionDelete()
    {
        $storyId = Yii::app()->input->get("id");

        Stories::model()->deleteByPk($storyId);

        Yii::app()->user->setFlash('success', "Story Deleted");

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

            Yii::app()->user->setFlash('success', "Saved");

        }
        else
        {
            Yii::app()->user->setFlash('error', "Shelter wasnt saved!");
        }

        $this->redirect($this->createUrl("story/edit", array(
            'id' => $story->story_id
        )));
    }
}
