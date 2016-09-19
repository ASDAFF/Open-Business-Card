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


class Articles extends ParentModel {
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{articles}}';
	}

	public function rules(){
		return array(
		    array('title, page_body', 'i18nRequired'),
		    array('title, seo_title', 'i18nLength', 'min'=>2, 'max'=>255),
			array($this->getI18nFieldSafe(), 'safe'),
		    array('page_body', 'i18nLength', 'min'=>2),
		    array('title, page_body, date_updated', 'safe', 'on'=>'search'),
		);
	}
	
	public function i18nFields(){
        return array(
            'title' => 'varchar(255) not null',
            'page_body' => 'text not null',
			'short_page_body' => 'text not null',
			'seo_title' => 'varchar(255) not null',
			'seo_keywords' => 'text not null',
			'seo_description' => 'text not null',
        );
    }

	public function attributeLabels(){
		return array(
			'title' => tc('Заголовок статьи'),
			'page_body' => tc('Текст статьи'),
			'short_page_body' => tc('Короткий текст статьи'),
			'date_updated' => tc('Дата создания'),
			'active' => tc('Статус'),
			'seo_title' => tc('Title страницы (для SEO)'),
			'seo_keywords' => tc('Keywords страницы (для SEO)'),
			'seo_description' => tc('Description страницы (для SEO)'),
		);
	}

	public function search(){
		$criteria=new CDbCriteria;
		$lang = Yii::app()->language;
		
		$criteria->compare('active', $this->active, true);		
		$criteria->compare("title_{$lang}", $this->{'title_'.$lang}, true);

		return new CustomActiveDataProvider($this, array(
		    'criteria'=>$criteria,
			'sort' => array(
				'defaultOrder' => 'sorter ASC',
			),
			'pagination'=>array(
				'pageSize'=>param('adminPaginationPageSize', 20),
			),
		));
	}

	public function behaviors(){
		return array(
			'AutoTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => null,
				'updateAttribute' => 'date_updated',
			),
		);
	}

	public function beforeSave(){
		if($this->isNewRecord){
			$this->active = 1;

			$maxSorter = Yii::app()->db->createCommand()
				->select('MAX(sorter) as maxSorter')
				//->where('active=1')
				->from('{{articles}}')
				->queryScalar();
			$this->sorter = $maxSorter+1;
		}
		return parent::beforeSave();
	}

	public function getUrl(){
		return Yii::app()->createUrl('/articles/main/view', array(
			'id'=>$this->id,
			'title'=>$this->title,
		));
	}

	public function getAllWithPagination($inCriteria = null){
		if($inCriteria === null){
			$criteria = new CDbCriteria;
			$criteria->addCondition('active = 1');
			$criteria->order = 'sorter ASC';
		} else {
			$criteria = $inCriteria;
		}

		$pages = new CPagination($this->count($criteria));
		$pages->pageSize = param('module_articles_itemsPerPage', 10);
		$pages->applyLimit($criteria);

		$items = $this->findAll($criteria);

		return array(
			'items' => $items,
			'pages' => $pages,
		);
	}
}