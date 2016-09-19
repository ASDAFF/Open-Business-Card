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


class GallerycategoryController extends ModuleAdminController{
	public $modelName = 'GalleryCategory';

	public function init() {
		$this->redirectTo = array('admin');
		parent::init();
	}

	public function getViewPath($checkTheme=false){
		return Yii::getPathOfAlias('application.modules.gallery.views.backend.gallerycategory');
	}

	public function actionAdmin(){
		Yii::app()->user->setState('menu_active', 'gallerycategory.admin');
		$this->getMaxSorter();
		$this->getMinSorter();
		parent::actionAdmin();
	}

	public function actionCreate() {
		Yii::app()->user->setState('menu_active', 'gallerycategory.create');
		parent::actionCreate();
	}
	
	public function actionUpdate($id){
		Yii::app()->user->setState('menu_active', 'gallerycategory.admin');
		parent::actionUpdate($id);
	}
}