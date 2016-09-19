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


class News extends ParentModel {
	public $dateCreated = array();
	public $dateCreatedAdmin;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{news}}';
	}

	public function rules() {
		return array(
			array('title', 'i18nRequired'),
			array('title, seo_title', 'i18nLength', 'max' => 255),
			array($this->getI18nFieldSafe(), 'safe'),
		);
	}

	public function i18nFields(){
		return array(
			'title' => 'varchar(255) not null',
			'body' => 'text not null',
			'short_body' => 'text not null',
			'seo_title' => 'varchar(255) not null',
			'seo_keywords' => 'text not null',
			'seo_description' => 'text not null',
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => tc('ID'),
			'title' => tc('Заголовок новости'),
			'body' => tc('Текст новости'),
			'short_body' => tc('Короткий текст новости'),
			'date_created' => tc('Дата добавления'),
			'dateCreated' => tc('Дата обновления'),
			'dateCreatedAdmin' => tc('Дата добавления'),
			'active' => tc('Статус'),
			'seo_title' => tc('Title страницы (для SEO)'),
			'seo_keywords' => tc('Keywords страницы (для SEO)'),
			'seo_description' => tc('Description страницы (для SEO)'),
		);
	}

	public function getUrl() {
		return Yii::app()->createUrl('/news/main/view', array(
			'id' => $this->id,
			'title' => $this->title,
		));
	}

	public function search() {
		$criteria = new CDbCriteria;
		$lang = Yii::app()->language;
		
		$criteria->compare('active', $this->active, true);
		$criteria->compare("title_{$lang}", $this->{'title_'.$lang}, true);

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

	public function behaviors(){
		return array(
			'AutoTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'date_created',
				'updateAttribute' => 'date_updated',
			),
		);
	}

	public function beforeSave(){
		if($this->isNewRecord){
			$this->active = 1;
		}
		return parent::beforeSave();
	}

	protected function afterFind() {
		$this->dateCreated['first'] = Yii::app()->dateFormatter->format('d', CDateTimeParser::parse($this->date_created, 'yyyy-MM-dd hh:mm:ss'));
		$this->dateCreated['second'] = Yii::app()->dateFormatter->format('MMM y', CDateTimeParser::parse($this->date_created, 'yyyy-MM-dd hh:mm:ss'));

		$dateFormat = param('dateFormat', 'd.m.Y H:i:s');
		$this->dateCreatedAdmin = date($dateFormat, strtotime($this->date_created));

		return parent::afterFind();
	}

	public function getAllWithPagination($inCriteria = null){
		if($inCriteria === null){
			$criteria = new CDbCriteria;
			$criteria->addCondition('active = 1');
			$criteria->order = 'date_created DESC';
		} else {
			$criteria = $inCriteria;
		}

		$pages = new CPagination($this->count($criteria));
		$pages->pageSize = param('module_news_itemsPerPage', 10);
		$pages->applyLimit($criteria);

		$items = $this->findAll($criteria);

		return array(
			'items' => $items,
			'pages' => $pages,
		);
	}
}