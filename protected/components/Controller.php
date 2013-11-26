<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    public function init()
    {
        Yii::app()->clientScript->registerScriptFile('/js/bootstrap-select.js', CClientScript::POS_END);
    }

	public function filters()
	{
		return array(
			//'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
    {	

        return array(
            array(
                'allow',
                'controllers' => array('city'),
                'users' => array('@'),
                'roles' => array(Users::ROLE_ADMIN),
            ),
            array(
                'allow',
                'controllers' => array('country'),
                'users' => array('@'),
                'roles' => array(Users::ROLE_ADMIN),
            ),
            array(
                'allow',
                'controllers' => array('explore'),
                'users' => array('*'),
            ),
            array(
                'allow',
                'controllers' => array('home'),
                'users' => array('*'),
            ),
            array(
                'allow',
                'controllers' => array('login'),
                'users' => array('*'),
            ),
            array(
                'allow',
                'controllers' => array('pledge'),
                'users' => array('@'),
                'roles' => array(Users::ROLE_ADMIN, Users::ROLE_CITY, Users::ROLE_SHELTER),
            ),
            array(
                'allow',
                'controllers' => array('region'),
                'users' => array('@'),
                'roles' => array(Users::ROLE_ADMIN),
            ),
            array(
                'allow',
                'controllers' => array('shelter'),
                'users' => array('@'),
                'roles' => array(Users::ROLE_ADMIN, Users::ROLE_CITY),
            ),
            array(
                'allow',
                'controllers' => array('story'),
                'users' => array('@'),
                'roles' => array(Users::ROLE_ADMIN, Users::ROLE_CITY, Users::ROLE_SHELTER, Users::ROLE_CONTRIBUTOR),
            ),
            array(
                'allow',
                'controllers' => array('user'),
                'users' => array('@'),
                'roles' => array(Users::ROLE_ADMIN, Users::ROLE_CITY),
            ),
            array('deny',
        		'users' => array('*'),
    		)
        );
    }
}