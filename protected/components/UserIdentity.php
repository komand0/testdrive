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
		$user = User::model()->find('LOWER(username)=?', array(strtolower($this->username)));
		if($user===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif(crypt($this->password, $user->password) !== $user->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else 
		{
			$this->_id = $user->id;
			$this->username = $user->username;
			$this->errorCode = self::ERROR_NONE;
		}
		return !$this->errorCode;
	}
	public function getId(){
		return $this->_id;
	}
}