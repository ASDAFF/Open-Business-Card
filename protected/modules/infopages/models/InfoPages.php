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

class InfoPages extends ParentModel {
	const STATUS_INACTIVE = 0;
	const STATUS_ACTIVE = 1;

	const MAIN_PAGE_ID = 1;
	const PRIVATE_POLICY_PAGE_ID = 2;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{infopages}}';
	}

	public function rules() {
		return array(
			array('title', 'i18nRequired'),
			array('title, seo_title', 'i18nLength', 'max' => 255),
			array($this->getI18nFieldSafe(), 'safe'),
			array('active, widget', 'safe'),
			array('active, title, body', 'safe', 'on' => 'search'),
		);
	}
	
	public function i18nFields(){
		return array(
			'title' => 'varchar(255) not null',
			'body' => 'text not null',
			'seo_title' => 'varchar(255) not null',
			'seo_keywords' => 'text not null',
			'seo_description' => 'text not null',
		);
	}

	public function relations(){
		return array(
			'menuPage' => array(self::HAS_MANY, 'Menu', 'pageId'),
		);
	}

	public function behaviors(){
		return array(
			'AutoTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'date_created',
				'updateAttribute' => 'date_updated',
			),
		);
	}

	public function attributeLabels() {
		return array(
			'id' => tc('ID'),
			'active' => tc('Статус'),
			'title' => tc('Заголовок страницы'),
			'body' => tc('Содержимое страницы'),
			'date_created' => tc('Дата добавления'),
			'widget' => tc('Отобразить снизу страницы'),
			'seo_title' => tc('Title страницы (для SEO)'),
			'seo_keywords' => tc('Keywords страницы (для SEO)'),
			'seo_description' => tc('Description страницы (для SEO)'),
		);
	}

	public function getUrl() {
		return Yii::app()->createAbsoluteUrl('/infopages/main/view', array(
			'id' => $this->id,
			'title' => $this->title,
		));
	}
	
	public function getGridViewUrl() {
		if ($this->id == InfoPages::PRIVATE_POLICY_PAGE_ID || $this->special == 0) {
			return $this->getUrl();
		}
		return "";
	}

	public function search() {
		$criteria = new CDbCriteria;
		$lang = Yii::app()->language;
		
		$criteria->compare("title_{$lang}", $this->{'title_'.$lang}, true);
		$criteria->compare("body_{$lang}", $this->{'body_'.$lang}, true);

		$criteria->compare($this->getTableAlias().'.active', $this->active, true);

		return new CustomActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array(
				'defaultOrder' => 'id DESC',
			),
			'pagination' => array(
				'pageSize' => param('adminPaginationPageSize', 20),
			),
		));
	}

	public static function getWidgetOptions($widget = null){
		$arrWidgets =  array(
			'' => tc('Нет'),
			'news' => tc('Новости'),
			'articles' => tc('Статьи'),
			'gallery' => tc('Галерея'),
			'catalog' => tc('Каталог товаров'),
			'price' => tc('Прайс-лист'),
			'contactform' => tc('Форма "Свяжитесь с нами"'),
		);

		if ($widget && array_key_exists($widget, $arrWidgets))
			return $arrWidgets[$widget];

		return $arrWidgets;
	}

	public static function getInfoPagesAddList() {
		$return = array();
		$result = InfoPages::model()->findAll('active = '.self::STATUS_ACTIVE);
		if ($result) {
			foreach($result as $item) {
				$return[$item->id] = $item->title;
			}
		}

		return $return;
	}
}