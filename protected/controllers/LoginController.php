<?php

class LoginController extends Controller
{
    public function actionIndex()
    {        
        
        // Render
        //$this->layout = "/layouts/pageshell-public";
        $this->pageTitle = 'Login';
        $this->render('/login/index/main');
    }

    public function actionLoginProcessor()
    {
        $email = Yii::app()->input->post('email');
        $password = Yii::app()->input->post('password');
        $redirectUrl = '';

        $identity = new UserIdentity($email, $password);

        if ($identity->authenticate()) {
            //log user in for 7 days using cookies
            Yii::app()->user->login($identity,3600*24*7);
            $this->redirect($this->createUrl('home/index'));
        }
        else {
            echo $identity->errorMessage;
        }
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
    }
    
    /*
     * Redirects the user after a sucessful login
     * Takes into A/B testing into account
     * @param String $redirectURLFromPost: Highest priority redirect url to use
     */
    private function _redirectLogin($redirectURLFromPost = null)
    {
        // Defaults Base Redirect is admin
		$redirectURL = $this->createUrl('admin/index');
		
		//if the user isnt logged in
        if(Yii::app()->user->isGuest)
        {
            //default redirect
            $redirectURL = $this->createUrl('login/index');

            // Check if there was a requested redirect URL
            if(!empty($redirectURLFromPost))
            {
                $redirectURL = $this->createUrl('login/index', array('redirect' => urlencode($redirectURLFromPost)));
            }
        }
        else
        {
            // Check if there was a requested redirect URL
            if(!empty($redirectURLFromPost))
            {
                $redirectURL = $redirectURLFromPost;
            }
        }
        
        // Perform the redirect
        $this->redirect($redirectURL);
    }
}