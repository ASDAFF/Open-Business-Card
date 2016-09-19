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


class Configuration extends CComponent {

	public $cachingTime;
	public static $cacheName = 'module_configuration_model';

	public function init(){
		$this->cachingTime = param('cachingTime', 5184000); // default caching for 60 days
		if (file_exists(ALREADY_INSTALL_FILE)) {
			$this->loadConfig();
		}
	}

	private function loadConfig() {
		Yii::import('application.modules.configuration.models.ConfigurationModel');
		$model = Yii::app()->cache->get(self::$cacheName);
		if($model === false) {
			$model = ConfigurationModel::model()->findAll();
			Yii::app()->cache->set(self::$cacheName, $model, $this->cachingTime);
		}
		foreach ($model as $key) {
			Yii::app()->params[$key->name] = $key->value;
		}
	}

	public static function clearCache(){
		Yii::app()->cache->delete(self::$cacheName);
	}
}