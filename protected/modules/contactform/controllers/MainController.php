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


class MainController extends ModuleUserController{
	public $modelName = 'ContactForm';

	public function init() {
		parent::init();

		$contactPage = Menu::model()->findByPk(Menu::CONTACT_ID);
		if ($contactPage) {
			if ($contactPage->active == 0) {
				throw404();
			}
		}
	}

	public function getViewPath($checkTheme=false){
		return Yii::getPathOfAlias('application.modules.contactform.views');
	}

	public function actions() {
		return array(
			'captcha' => array(
				'class' => 'MathCCaptchaAction',
				'backColor' => 0xFFFFFF,
			),
		);
	}

	public function actionIndex(){
		$model = new $this->modelName;
		$this->getHeaders($model);
		$this->render('contactform');
	}
}