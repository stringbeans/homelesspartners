<?php

class LoginController extends Controller
{
    public function actionIndex()
    {
    	if(!Yii::app()->user->isGuest)
    	{
    		$this->redirect($this->createUrl('home/index'));
    	}
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
    	if(!Yii::app()->user->isGuest)
    	{
    		$this->redirect($this->createUrl('home/index'));
    	}
        Yii::app()->clientScript->registerScriptFile('/js/jquery.validate.js', CClientScript::POS_END);
        $this->pageTitle = 'Register';
        $this->render('/login/register/main');
    }

    public function actionRegisterProcessor()
    {
        $email = Yii::app()->input->post('email');
        $password = Yii::app()->input->post('password');
        $name = Yii::app()->input->post('name');

        $redirectUrl = Yii::app()->input->post('redirectUrl', $this->createUrl("home/index"));

        $validRegistrationInfo = true;
        if(empty($name))
        {
            $validRegistrationInfo = false;
            Yii::app()->user->setFlash('error', 'This enter a name');
        }

        if(empty($email))
        {
            $validRegistrationInfo = false;
            Yii::app()->user->setFlash('error', 'This enter an email');
        }

        if(empty($password) || strlen($password) < 6 || strlen($password) > 16)
        {
            $validRegistrationInfo = false;
            Yii::app()->user->setFlash('error', 'Your password must be atleast six characters long, and less than 16');
        }

        if(!$validRegistrationInfo)
        {
            $this->redirect($this->createUrl('login/register'));
        }

        $user = null;
        try {
            $user = Users::model()->create($name, $email, $password);
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

    public function actionforgotPassword()
    {
    	if(!Yii::app()->user->isGuest)
    	{
    		$this->redirect($this->createUrl('home/index'));
    	}
        $this->pageTitle = 'Forgot Password';
        $this->render('/login/forgotpassword/main');
    }

    public function actionforgotPasswordProcessor()
    {
        $email = Yii::app()->input->post('email');
        $user = Users::model()->findByAttributes(array('email' => $email));

        if(empty($user))
        {
            Yii::app()->user->setFlash('error', 'There is no account using this email address. You can <a href="' . Yii::app()->createUrl('login/register') . '">register</a> an account using this email.');
            $this->redirect($this->createUrl('login/forgotPassword'));
        }
        $resetPasswordKey = uniqid();
        $user->reset_key = $resetPasswordKey;
        $user->reset_key_expires_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). ' + 1  days'));
        $user->save();
        
        $text = "Click the following link to reset your password:\n\n" . Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('login/resetPassword', array('user_id' => $user->user_id, 'key' => $resetPasswordKey)) . "\n\nIf you didn't request a password reset, simply disregard this email.\n\n- Homeless Partners Team");
        $html = "Click the following link to reset your password:<br /><br />" . Yii::app()->createAbsoluteUrl(Yii::app()->createUrl('login/resetPassword', array('user_id' => $user->user_id, 'key' => $resetPasswordKey)) . "<br /><br />If you didn't request a password reset, simply disregard this email.<br /><br />- Homeless Partners Team");

        $emailMessage = new Email();
        $emailMessage->send('Homeless Partners <' . Yii::app()->params['HP_SENDER_NO_REPLY_EMAIL_ADDRESS'] . '>', $email, 'Reset Password Request', $text, $html);


        Yii::app()->user->setFlash('success', 'A reset password link has been sent to your email.');
        $this->render('/login/forgotpassword/main');
    }

    public function actionResetPassword()
    {
    	if(!Yii::app()->user->isGuest)
    	{
    		$this->redirect($this->createUrl('home/index'));
    	}
        Yii::app()->clientScript->registerScriptFile('/js/jquery.validate.js', CClientScript::POS_END);
        $resetPasswordKey = Yii::app()->input->get('key');
        $userId = Yii::app()->input->get('user_id');
        $this->render('/login/resetpassword/main', array(
            'resetPasswordKey' => $resetPasswordKey,
            'userId' => $userId
        ));
    }

    public function actionResetPasswordProcessor()
    {
        $password = Yii::app()->input->post('password');
        $userId = Yii::app()->input->post('userId');
        $resetPasswordKey = Yii::app()->input->post('resetPasswordKey');

        if(empty($password) || strlen($password) < 6 || strlen($password) > 16)
        {
            Yii::app()->user->setFlash('error', 'Your password must be atleast six characters long, and less than 16');
            $this->redirect($this->createUrl('login/resetPassword', array('key' => $resetPasswordKey)));
        }

        $user = Users::model()->findByPk($userId);

        if(empty($user) || $user->reset_key != $resetPasswordKey)
        {
            Yii::app()->user->setFlash('error', 'There was an error resetting your password');
            $this->redirect($this->createUrl('login/resetPassword', array('key' => $resetPasswordKey)));
        }

        if(strtotime($user->reset_key_expires_date) > strtotime(date('Y-m-d H:i:s')))
        {
            $user->pw = $password;
            $user->reset_key = null;
            $user->reset_key_expires_date = null;
            $user->save();
            Yii::app()->user->setFlash('success', 'Your password has been changed. Please login.');
            $this->redirect($this->createUrl('login/index'));
        }
        Yii::app()->user->setFlash('error', 'There was an error resetting your password');
        $this->redirect($this->createUrl('login/resetPassword', array('key' => $resetPasswordKey)));
    }
}