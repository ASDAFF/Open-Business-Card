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

class InstallForm extends CFormModel {

    public $agreeLicense;

    public $dbHost = 'localhost';
    public $dbPort = '3306';
    public $dbUser = 'root';
    public $dbPass;
	public $dbName;
	public $dbPrefix;
	public $language;

	public $adminName;
	public $adminPass;
	public $adminEmail;

    public $siteName = 'Open Business Card';
    public $siteKeywords;
    public $siteDescription;

    public function init() {
		$this->language = Yii::app()->language;
		$this->dbPrefix = 'obc_'.InstallForm::randomDBPrefix(2).'_';
        return parent::init();
    }

	public function getLangs(){
		return array(
			'en' => 'English / Английский / Englisch',
			'ru' => 'Russian / Русский / Russisch',
		);
	}

	public function rules()	{
		return array(
			array('dbUser, dbHost, dbName, adminPass, adminEmail, adminName, dbPrefix, siteName', 'required'),
			array('agreeLicense', 'required', 'requiredValue' => true, 'message'=> tFile::getT('module_install', 'You should agree with "The license agreement"')),
			array('adminEmail', 'email'),
			array('dbUser, dbPass, dbName', 'length', 'max' => 30),
			array('dbHost', 'length', 'max' => 50),
			array('adminPass', 'length', 'max' => 20, 'min' => 6),
            array('dbPort', 'length', 'max' => 5),
			array('dbPort', 'numerical', 'allowEmpty' => true, 'integerOnly' => true),
			array('dbPrefix', 'length', 'max' => 7, 'min' => 1),
			array('dbPrefix', 'match', 'pattern' => '#^[a-zA-Z0-9_]{1,7}$#', 'message'=> tFile::getT('module_install', 'It is allowed to use the characters "a-zA-Z0-9_" without spaces')),
			array('dbPrefix, dbPort, siteName, siteKeywords, siteDescription', 'safe'),
			array('language', 'in' ,'range' => array('en', 'ru', 'de'), 'allowEmpty' => false),
		);
	}

	public function attributeLabels() {
		$lang = tFile::getT('module_install', 'Preferred site language');

		return array(
            'agreeLicense' => tFile::getT('module_install', 'I agree with').' ' . CHtml::link(tFile::getT('module_install', 'License agreement'), '#licensewidget',
                                                            array('class'=>'fancy mgp-open-inline')).
															(($this->language == 'de') ? ' zu' : ''),
            'dbHost' => tFile::getT('module_install', 'Database server'),
            'dbPort' => tFile::getT('module_install', 'Database port'),
            'dbUser' => tFile::getT('module_install', 'Database user name'),
            'dbPass' => tFile::getT('module_install', 'Database user password'),
            'dbName' => tFile::getT('module_install', 'Database name'),
            'dbPrefix' => tFile::getT('module_install', 'Prefix for tables'),
            'adminName' => tFile::getT('module_install', 'Administrator name'),
            'adminPass' => tFile::getT('module_install', 'Administrator password'),
            'adminEmail' => tFile::getT('module_install', 'Administrator email'),
			'language' => $lang,
            'siteName' => tFile::getT('module_install', 'siteName'),
            'siteKeywords' => tFile::getT('module_install', 'siteKeywords'),
            'siteDescription' => tFile::getT('module_install', 'siteDescription'),
		);
	}
	
	public static function randomDBPrefix($length = 10){
		$chars = range('a','z');
		shuffle($chars);
		return implode('', array_slice($chars, 0, $length));
	}
}