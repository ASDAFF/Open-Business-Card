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


class ImagesController extends ModuleAdminController{
	public $modelName = 'CatalogImages';
	public $defaultAction = 'admin';

	public function init() {
		$this->redirectTo = Yii::app()->controller->createAbsoluteUrl('/catalog/backend/catalog/admin');
		parent::init();
	}

	public function getViewPath($checkTheme=false){
		return Yii::getPathOfAlias('application.modules.catalog.views.backend.catalog');
	}

	public function actionAdmin(){
		$this->redirect(array($this->redirectTo));
	}
}
