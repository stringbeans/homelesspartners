<?php
/**
 * This replaces the CPhpAuthManager
 *
 * I didn't like how CPhpAuthManager needed to write to a physical file to store access rules, so i created this simple overwrite
 * of it. We could still use the method CPhpAuthManager prescribes where it writes to an auth.php file in protected/data but it
 * makes no sense.
 */
class AuthManager extends CPhpAuthManager
{
    public function checkAccess($operation,$params=array(),$allowCaching=true)
    {
        $result = false;
        if(!Yii::app()->user->isGuest)
        {
            $role = Yii::app()->user->role;
            
            if($operation == $role)
            {
                $result = true;
            }
        }
        
        return ($result || parent::checkAccess($operation, $params, $allowCaching));
    }
}