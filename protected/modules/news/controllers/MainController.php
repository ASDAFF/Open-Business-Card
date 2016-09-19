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
	public $modelName = 'News';

	public function init() {
		parent::init();

		$newsPage = Menu::model()->findByPk(Menu::NEWS_ID);
		if ($newsPage) {
			if ($newsPage->active == 0) {
				throw404();
			}
		}
	}

	public function actionIndex(){
		$model = new $this->modelName;
		$this->getHeaders($model);

		$criteria=new CDbCriteria;
		$criteria->addCondition('active = 1');
		$criteria->order = 'date_created DESC';

		$result = $model->getAllWithPagination($criteria);

		$this->render('index', array(
			'items' => $result['items'],
			'pages' => $result['pages'],
		));
	}
}