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


class MainController extends ModuleUserController {
	public $modelName = 'Reviews';

	public function init() {
		parent::init();

		$reviewsPage = Menu::model()->findByPk(Menu::REVIEWS_ID);
		if ($reviewsPage) {
			if ($reviewsPage->active == 0) {
				throw404();
			}
		}
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
		$criteria=new CDbCriteria;
		//$criteria->order = 'sorter';
		$criteria->order = 'date_created DESC';
		$criteria->condition = 'active='.Reviews::STATUS_ACTIVE;

		$pages = new CPagination(Reviews::model()->count($criteria));
		$pages->pageSize = param('module_reviews_itemsPerPage', 10);
		$pages->applyLimit($criteria);

		$reviews = Reviews::model()->cache(param('cachingTime', 1209600), Reviews::getCacheDependency())->findAll($criteria);

		$this->getHeaders($reviews);

		$this->render('index',array(
			'reviews' => $reviews, 'pages' => $pages
		));
	}

	public function actionAdd(){
		$model = new Reviews;
		$this->pageTitle = Yii::app()->name . ' - '.tc('Отзывы').' - '.tc('Добавить');

		//$this->performAjaxValidation($model);
		if(isset($_POST[$this->modelName])){
			$model->attributes = $_POST[$this->modelName];

			if($model->validate()){
				if ($model->save(false)) {
					$notifier = new Notifier;
					if ($notifier->reviewsForm($model)) {
						Yii::app()->user->setFlash('success', tc('Отзыв успешно отправлен и будет доступен после модерации.'));
						$model->unsetAttributes(); // clear fields
					}
					else {
						Yii::app()->user->setFlash('error', tc('Отзыв не был отправлен! Исправьте, пожалуйста, ошибки и повторите снова.'));
					}
				}
				$model->unsetAttributes(array('name', 'body','verifyCode'));
			}
			$model->unsetAttributes(array('verifyCode'));
		}

		$this->render('add',array('model'=>$model));
	}
}