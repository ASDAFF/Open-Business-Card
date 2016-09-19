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
	public $modelName = 'TranslateMessage';

	public function actionIndex(){
		$this->redirect(array('admin'));
	}

	public function actionView($id){
		$this->redirect(array('admin'));
	}

	public function actionAdmin(){

		$this->rememberPage();

		$model = new TranslateMessage('search');

		$model->setRememberScenario('translate_remember');

		$this->render('admin',array(
				'model'=>$model,
		));
	}
}