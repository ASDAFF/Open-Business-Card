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
	public $modelName = 'Price';

	public function init() {
		parent::init();

		$pricePage = Menu::model()->findByPk(Menu::PRICE_ID);
		if ($pricePage) {
			if ($pricePage->active == 0) {
				throw404();
			}
		}
	}

	public function actionIndex(){
		$model = new $this->modelName;
		$this->getHeaders($model);

		$result = PriceCategory::model()->getAllWithPrice();

		$this->render('index', array(
			'price' => $result['price'],
			'model' => $model,
		));
	}
}