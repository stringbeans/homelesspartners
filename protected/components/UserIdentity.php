<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;

    public function authenticate()
    {
        $record = Users::model()->findByAttributes(array('email' => $this->username));
        if ($record === null) {
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        } elseif ($record->pw !== $this->password) {
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        } else {
            $this->_id=$record->user_id;
            $this->setState('role', $record->role_new);
            $this->errorCode=self::ERROR_NONE;
        }
        return !$this->errorCode;
    }
 
    public function getId()
    {
        return $this->_id;
    }
}