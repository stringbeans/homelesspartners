<?php

class SearchController extends Controller
{

	public function actionIndex()
	{
		$query = Yii::app()->input->post('query', '');
		$filter = Yii::app()->input->post('filter', 'all');

		$filters = array(
			'all' => 'All Fields',
			'assignee' => 'Assigned ID',
			'name' => 'Name',
			'gift' => 'Gift'
		);

		switch ($filter) {
			case 'assignee':
				$results = Stories::model()->getStorySearchResultsByAssignee($query);
				break;
			case 'name':
				$results = Stories::model()->getStorySearchResultsByName($query);
				break;
			case 'gift':
				$results = Stories::model()->getStorySearchResultsByGiftDescription($query);
				break;
			case 'all':
			default:
				$results = Stories::model()->getStorySearchResultsByAll($query);
				break;
		}


		$this->render("/search/index/main", compact('query', 'filter', 'filters', 'results'));

	}
}