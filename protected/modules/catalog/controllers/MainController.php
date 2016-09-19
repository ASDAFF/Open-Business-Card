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
	public $modelName = 'Catalog';

	public function init() {
		parent::init();

		$catalogPage = Menu::model()->findByPk(Menu::CATALOG_ID);
		if ($catalogPage) {
			if ($catalogPage->active == 0) {
				throw404();
			}
		}
	}

	public function actionIndex($catid = '', $subcatid = ''){
		$model = new $this->modelName;
		$this->getHeaders($model);

		$criteria=new CDbCriteria;
		$criteria->order = 't.sorter ASC';
		$criteria->addCondition('t.active=1');
		$with = array('catalogCategory', 'catalogImages');

		$categoryName = $subCategoryName = null;
		if ($catid) {
			$criteria->addCondition('t.id_category='.$catid);
			$categoryName = CatalogCategory::model()->findByPk($catid);
		}

		if (param('useTwoLevelCatalog', 0)) {
			$with = CMap::mergeArray($with, array('catalogSubCategory'));
			
			if ($subcatid) {
				$criteria->addCondition('t.id_sub_category='.$subcatid);
				$subCategoryName = CatalogSubCategory::model()->findByPk($subcatid);

				$categoryName = CatalogCategory::model()->findByPk($subCategoryName->id_category);
			}
		}
		
		$criteria->with = $with;

		$result = $model->getAllWithPagination($criteria);

		$criteria=new CDbCriteria;
		$criteria->order = 't.sorter ASC';
		$criteria->addCondition('t.active=1');
		$criteria->addCondition('catalog.active=1');
		$categories = CatalogCategory::model()->with(array('catalog'))->findAll($criteria);

		$this->render('/index',array(
			'catalog' => $result['items'], 'pages' => $result['pages'],
			'categories' => $categories, 'categoryName' => $categoryName,
			'subCategoryName' => $subCategoryName
		));
	}

	public function actionView($id){
		$this->render('view', array(
			'model' =>  $this->loadModelWith(array('catalogCategory', 'catalogImages')),
		));
	}
}