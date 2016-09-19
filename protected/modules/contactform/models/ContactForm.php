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

class ContactForm extends CFormModel {
	public $name;
	public $email;
	public $body;
	public $verifyCode;
	public $phone;
	public $useremail;
	public $username;

	public function rules()	{
		return array(
			array('name, email, body', 'required'),
			array('email', 'email'),
			array('verifyCode', 'captcha', 'allowEmpty'=>!Yii::app()->user->isGuest),
			array('phone', 'safe'),
			array('name, email', 'length', 'max' => 128),
			array('phone', 'length', 'max' => 16, 'min' => 5),
			array('body', 'length', 'max' => 1024),
		);
	}

	public function attributeLabels() {
		return array(
			'name' => tc('Имя'),
			'email' => tc('Email'),
			'phone' => tc('Телефон'),
			'body' => tc('Сообщение'),
			'verifyCode' => tc('Проверочный код'),
		);
	}
}