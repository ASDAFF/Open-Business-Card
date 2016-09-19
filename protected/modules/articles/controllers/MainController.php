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
	public $modelName = 'Articles';

	public function init() {
		parent::init();

		$articlesPage = Menu::model()->findByPk(Menu::ARTICLES_ID);
		if ($articlesPage) {
			if ($articlesPage->active == 0) {
				throw404();
			}
		}
	}

	public function actionIndex(){
		$model = new $this->modelName;
		$this->getHeaders($model);

		$criteria=new CDbCriteria;
		$criteria->addCondition('active = 1');
		$criteria->order = 'sorter ASC';

		$pages = new CPagination(Articles::model()->count($criteria));
		$pages->pageSize = param('module_articles_itemsPerPage', 10);
		$pages->applyLimit($criteria);

		$articles = Articles::model()->findAll($criteria);

		$this->render('/index',array(
			'articles' => $articles, 'pages' => $pages
		));
	}

	public function actionView($id){
		$model = new $this->modelName;
		$this->getHeaders($model);

		$criteria=new CDbCriteria;
		$criteria->addCondition('active = 1');
		$criteria->order = 'sorter ASC';

		$articles = Articles::model()->findAll($criteria);

		$this->render('view',array(
			'model'=>$this->loadModel($id), 'articles' => $articles
		));
	}
}