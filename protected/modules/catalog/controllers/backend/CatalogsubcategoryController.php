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


class CatalogsubcategoryController extends ModuleAdminController{
	public $modelName = 'CatalogSubCategory';

	public function init() {
		$this->redirectTo = array('admin');

		if (!param('useTwoLevelCatalog', 0))
			$this->redirect(array('/menumanager/backend/main/admin'));

		parent::init();
	}

	public function getViewPath($checkTheme=false){
		return Yii::getPathOfAlias('application.modules.catalog.views.backend.catalogsubcategory');
	}

	public function actionAdmin(){
		Yii::app()->user->setState('menu_active', 'catalogsubcategory.admin');
		$this->getMaxSorter();
		$this->getMinSorter();		
		parent::actionAdmin();
	}

	public function actionCreate() {
		Yii::app()->user->setState('menu_active', 'catalogsubcategory.create');
		parent::actionCreate();
	}
	
	public function actionUpdate($id){
		Yii::app()->user->setState('menu_active', 'catalogsubcategory.admin');
		parent::actionUpdate($id);
	}
}