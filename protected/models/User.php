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

class User extends CActiveRecord {

	private static $_saltAddon = 'company';
	public $password_repeat;
	public $old_password;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{users}}';
	}

	public function relations(){
		return array(

		);
	}

	public function rules() {
		return array(
			array('email', 'length', 'max' => 64),
			array('old_password, email', 'required', 'on' => 'changeAdminInfo'),
			array('password, password_repeat', 'passValidator', 'on' => 'changeAdminInfo'),
			array('password_repeat', 'safe'),
		);
	}

	public function passValidator() {
		if ($this->password) {
			if (empty($this->password_repeat))
				$this->addError('password_repeat', tc('Заполните поле'));
			if ($this->password != $this->password_repeat)
				$this->addError('password', tc('Пароли не совпадают'));
			if (utf8_strlen($this->password) < 6)
				$this->addError('password', tc('Минимальная длина пароля 6 символов'));
		}
	}

	public function attributeLabels() {
		$return = array(
			'password' => tc('Пароль'),
			'old_password' => tc('Прежний пароль'),
			'password_repeat' => tc('Повторите пароль'),
		);
		return $return;
	}

	public function validatePassword($password) {
		return self::hashPassword($password, $this->salt) === $this->password;
	}

	public static function hashPassword($password, $salt) {
		return md5($salt . $password . $salt . self::$_saltAddon);
	}

	public static function generateSalt() {
		return uniqid('', true);
	}

	public function setPassword($password = null){
		$this->salt = self::generateSalt();
		if($password == null){
			$password = $this->password;
		}
		$this->password = md5($this->salt . $password . $this->salt . self::$_saltAddon);
	}

	public function randomString($length = 10){
		$chars = array_merge(range(0,9), range('a','z'), range('A','Z'));
		shuffle($chars);
		return implode(array_slice($chars, 0, $length));
	}
}