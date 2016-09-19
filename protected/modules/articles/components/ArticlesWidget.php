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

class ArticlesWidget extends CWidget {

	public $usePagination = 1;

	public function getViewPath($checkTheme=false){
		return Yii::getPathOfAlias('application.modules.articles.views');
	}

	public function run() {
		$articles = new Articles;

		$criteria = new CDbCriteria;
		$criteria->addCondition('active = 1');
		$criteria->order = 'sorter ASC';

		$result = $articles->getAllWithPagination($criteria);

		$this->render('widgetArticles_list', array(
			'articles' => $result['items'],
			'pages' => $result['pages'],
		));
	}
}