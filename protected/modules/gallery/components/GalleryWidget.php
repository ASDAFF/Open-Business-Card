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

class GalleryWidget extends CWidget {

	public $usePagination = 1;

	public function getViewPath($checkTheme=false){
		return Yii::getPathOfAlias('application.modules.gallery.views');
	}

	public function run() {
		$gallery = new Gallery;

		$criteria = new CDbCriteria;
		$criteria->addCondition('t.active = 1');
		$criteria->order = 't.sorter ASC';

		$categoryName = $categories = null;
		if (param('useGalleryGategory', 0)) {
			$catid = Yii::app()->request->getParam('catid', null);
			if ($catid) {
				$criteria->addCondition('t.id_category='.$catid);
				$categoryName = CatalogCategory::model()->findByPk($catid);
			}
			$criteria->with = array('galleryCategory');
		}

		$result = $gallery->getAllWithPagination($criteria, true);

		if (param('useGalleryGategory', 0)) {
			$criteria=new CDbCriteria;
			$criteria->order = 't.sorter ASC';
			$criteria->addCondition('t.active=1');
			$criteria->addCondition('gallery.active=1');
			$categories = GalleryCategory::model()->with(array('gallery'))->findAll($criteria);
		}

		$this->render('widgetGallery_list', array(
			'gallery' => $result['items'],
			'pages' => $result['pages'],
			'categories' => $categories,
			'categoryName' => $categoryName
		));
	}
}