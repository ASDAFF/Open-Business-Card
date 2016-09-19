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


class MainController extends ModuleAdminController{
	public $modelName = 'Reviews';
	public $redirectTo = array('admin');

	public function actionView($id){
		$this->render('view',array(
			'model'=>$this->loadModel($id)
		));
	}

	public function actionAdmin(){
		$this->getMaxSorter();
		$this->getMinSorter();
		parent::actionAdmin();
	}

	public function actionCreate(){
		Yii::app()->user->setState('menu_active', 'reviews.create');
		parent::actionCreate();
	}
}