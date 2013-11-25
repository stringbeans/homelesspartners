<?php

class HomeController extends Controller
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->render('/home/index/main');
        //$this->render('/home/static/cityshelters');
        //$this->render('/home/static/shelterstories');
        //$this->render('/home/static/story');
	}
}
