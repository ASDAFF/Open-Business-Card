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

class ContactformWidget extends CWidget {
	public $page;

	public function getViewPath($checkTheme=false){
		return Yii::getPathOfAlias('application.modules.contactform.views');
	}

	public function run() {
		Yii::import('application.modules.contactform.models.ContactForm');
		$model = new ContactForm;
		$model->scenario = 'insert';

		if(isset($_POST['ContactForm'])){
			$model->attributes=$_POST['ContactForm'];

			if(!Yii::app()->user->isGuest){
				$model->email = Yii::app()->user->email;
			}

			if($model->validate()){
				$notifier = new Notifier;
				if ($notifier->contactForm($model)) {
					Yii::app()->user->setFlash('success', tc('Спасибо за связь с нами! Мы ответим Вам как можно быстрее.'));
					$model->unsetAttributes(); // clear fields
				}
				else {
					Yii::app()->user->setFlash('error', tc('Сообщение не было отправлено! Исправьте, пожалуйста, ошибки и повторите снова.'));
				}
			}
		}

		$this->render('widgetContactform', array('model' => $model));
	}
}