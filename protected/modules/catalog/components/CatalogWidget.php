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

class CatalogWidget extends CWidget {

	public $usePagination = 1;

	public function getViewPath($checkTheme=false){
		return Yii::getPathOfAlias('application.modules.catalog.views');
	}

	public function run() {
		$catalog = new Catalog;

		$criteria=new CDbCriteria;
		$criteria->order = 't.sorter ASC';
		$criteria->addCondition('t.active=1');
		$criteria->with = array('catalogCategory', 'catalogImages');

		$categoryName = null;
		$catid = Yii::app()->request->getParam('catid', null);
		if ($catid) {
			$criteria->addCondition('t.id_category='.$catid);
			$categoryName = CatalogCategory::model()->findByPk($catid);
		}

		$result = $catalog->getAllWithPagination($criteria);

		$criteria=new CDbCriteria;
		$criteria->order = 't.sorter ASC';
		$criteria->addCondition('t.active=1');
		$criteria->addCondition('catalog.active=1');
		$categories = CatalogCategory::model()->with(array('catalog'))->findAll($criteria);

		$this->render('widgetCatalog_list', array(
			'catalog' => $result['items'], 'pages' => $result['pages'],
			'categories' => $categories, 'categoryName' => $categoryName
		));
	}
}