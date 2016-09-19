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


class Module extends CWebModule {

	public $defaultController = 'main';

	public function init() {
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		// import the module-level models and components
		$this->setImport(array(
			'application.modules.'.$this->getName() . '.models.*',
			'application.modules.'.$this->getName() . '.components.*',
		));
        // echo Yii::app()->getViewPath();
        //echo Yii::app()->getBasePath() . '/modules/' . $this->getName(). '/views';
		$this->setViewPath(Yii::app()->getBasePath() . '/modules/' . $this->getName(). '/views');
	}
}
