<?php

class LoginController extends Controller
{
    public function actionIndex()
    {
        $this->pageTitle = 'Login';
        $this->render('/login/index/main');
    }

    public function actionLoginProcessor()
    {
        $email = Yii::app()->input->post('email');
        $password = Yii::app()->input->post('password');
        $redirectUrl = Yii::app()->input->post('redirectUrl', $this->createUrl("home/index"));

        $identity = new UserIdentity($email, $password);

        if ($identity->authenticate()) {
            //log user in for 7 days using cookies
            Yii::app()->user->login($identity,3600*24*7);
            $this->redirect($redirectUrl);
        }
        else {
            Yii::app()->user->setFlash('error', 'Your credentials are incorrect.');
            $this->redirect($this->createUrl('login/index'));
        }
    }

    public function actionRegister()
    {
        $this->pageTitle = 'Register';
        $this->render('/login/register/main');
    }

    public function actionRegisterProcessor()
    {
        $email = Yii::app()->input->post('email');
        $password = Yii::app()->input->post('password');
        $redirectUrl = Yii::app()->input->post('redirectUrl', $this->createUrl("home/index"));

        $user = null;
        try {
            $user = Users::model()->create($email, $password);
        } catch (CDbException $e) {
            if (empty($user)) {
                $duplicateUser = Users::model()->findByAttributes(array('email' => $email));
                if (!empty($duplicateUser))
                {
                    Yii::app()->user->setFlash('error', 'This email address is already in use. Please login.');
                } else {
                    Yii::app()->user->setFlash('error', 'Error creating registration.');
                }
            }
            $this->redirect($this->createUrl('login/register'));
        }

        if (empty($user)) {
            Yii::app()->user->setFlash('error', 'Error creating registration.');
            $this->redirect($this->createUrl('login/register'));
        }

        $identity = new UserIdentity($email, $password);
        if ($identity->authenticate()) {
            //log user in for 7 days using cookies
            Yii::app()->user->login($identity,3600*24*7);
            $this->redirect($redirectUrl);
        }
        else {
            $this->redirect($this->createUrl('login/register'));
        }
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect($this->createUrl('home/index'));
    }
}