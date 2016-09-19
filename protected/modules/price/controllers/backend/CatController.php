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

class CatController extends ModuleAdminController{
	public $modelName = 'PriceCategory';
	public $defaultAction = 'admin';

	public function init() {
		parent::init();
		Yii::app()->user->setState('menu_active', 'price.createseparator');
	}

	public function getViewPath($checkTheme=false){
		return Yii::getPathOfAlias('application.modules.price.views.backend.category');
	}

	public function actionView($id) {
		$this->redirect('admin');
	}

	public function actionAdmin() {
		$this->getMaxSorter();
		$this->getMinSorter();
		parent::actionAdmin();
	}
}
