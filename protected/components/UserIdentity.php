<?php
/* * ********************************************************************************************
 *								Open Business Card
 *								----------------
 * 	version				:	1.5.1
 * 	copyright			:	(c) 2016 Monoray
 * 							http://monoray.net
 *							http://monoray.ru
 * 
 * 	contact us			:	http://monoray.net/contact
 *							http://monoray.ru/contact
 *
 * 	license:			:	http://open-real-estate.info/en/license
 * 							http://open-real-estate.info/ru/license
 *
 * This file is part of Open Business Card
 *
 * ********************************************************************************************* */


class UserIdentity extends CUserIdentity {

	private $_id;
	public $email;

	public function __construct($email,$password){
		$this->email = $email;
		$this->password = $password;
	}

	public function authenticate() {
		$user = User::model()->find('LOWER(email)=?', array(strtolower($this->email)));

		if ($user === null){
			$this->errorCode = self::ERROR_USERNAME_INVALID;
			return 0;
		}

		if (!$user->validatePassword($this->password)){
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
			return 0;
		}
		else {
			$this->_id = $user->id;

			$this->setState('email', $user->email);
			$this->setState('isAdmin', true);

			$this->errorCode = self::ERROR_NONE;
		}
		return $this->errorCode == self::ERROR_NONE;
	}

	public function getId() {
		return $this->_id;
	}

}