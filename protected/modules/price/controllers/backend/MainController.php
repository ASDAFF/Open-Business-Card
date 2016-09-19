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
	public $modelName = 'Price';
	public $maxSorters = array();
	public $minSorters = array();

	public function actionView($id){
		$this->redirect(array('admin'));
	}
	public function actionIndex(){
		$this->redirect(array('admin'));
	}

	public function actionAdmin(){
		$sql = 'SELECT cat_id, MAX(sorter) as sorter FROM '.Price::model()->tableName().' GROUP BY cat_id';
		$sorters = Yii::app()->db->createCommand($sql)->queryAll();
		foreach($sorters as $sorter){
			$this->maxSorters[$sorter['cat_id']] = $sorter['sorter'];
		}

		$sql = 'SELECT cat_id, MIN(sorter) as sorter FROM '.Price::model()->tableName().' GROUP BY cat_id';
		$sorters = Yii::app()->db->createCommand($sql)->queryAll();
		foreach($sorters as $sorter){
			$this->minSorters[$sorter['cat_id']] = $sorter['sorter'];
		}

		parent::actionAdmin();
	}

	public function actionCreate() {
		$this->scenario = 'create';
		Yii::app()->user->setState('menu_active', 'price.create');
		parent::actionCreate();
	}

	public function actionUpdate($id) {
		$this->scenario = 'update';
		parent::actionUpdate($id);
	}
}
