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
	public $modelName = 'Gallery';

	public function init() {
		parent::init();

		$galleryPage = Menu::model()->findByPk(Menu::GALLERY_ID);
		if ($galleryPage) {
			if ($galleryPage->active == 0) {
				throw404();
			}
		}
	}

	public function actionIndex(){
		$catid = '';
		if (param('useGalleryGategory', 0)) {
			$catid = (int) Yii::app()->request->getParam('catid');
		}

		$categoryName = $categories = null;

		$model = new $this->modelName;
		$this->getHeaders($model);

		$criteria=new CDbCriteria;

		if ($catid && param('useGalleryGategory')) {
			$criteria->addCondition('t.id_category='.$catid);
			$categoryName = GalleryCategory::model()->findByPk($catid);
		}

		$criteria->addCondition('active = 1');
		$criteria->order = 'sorter ASC';

		$result = $model->getAllWithPagination($criteria, true);

		if (param('useGalleryGategory')) {
			$criteria=new CDbCriteria;
			$criteria->order = 't.sorter ASC';
			$criteria->addCondition('t.active=1');
			$criteria->addCondition('gallery.active=1');
			$categories = GalleryCategory::model()->with(array('gallery'))->findAll($criteria);
		}

		$this->render('index', array(
			'gallery' => $result['items'],
			'pages' => $result['pages'],
			'categories' => $categories,
			'categoryName' => $categoryName,
		));
	}
}