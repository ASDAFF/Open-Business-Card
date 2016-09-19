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


class CatalogSubCategory extends ParentModel {
	private static $_catalogSubCategories;
	private static $_activeCatalogSubCategories;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{catalog_sub_category}}';
	}

	public function relations() {
		return array(
			'catalog' => array(self::HAS_MANY, 'Catalog', 'id_category',
				'on' => 'catalog.active = 1',
				'order' => 'catalog.sorter ASC',
			),
			'category' => array(self::BELONGS_TO, 'CatalogCategory', 'id_category'),
		);
	}

	public function rules(){
		return array(
			array('id_category', 'required'),
			array('title', 'i18nRequired'),
		    array('title', 'i18nLength', 'min'=>2, 'max'=>255),
			array($this->getI18nFieldSafe(), 'safe'),
			array('title, id, id_category', 'safe', 'on'=>'search'),
		);
	}
	
	public function i18nFields(){
        return array(
            'title' => 'varchar(255) not null',
        );
    }

	public function attributeLabels(){
		return array(
			'ID' => tc('ID'),
			'id_category' => tc('Категория'),
			'title' => tc('Название подкатегории'),
			'date_updated' => tc('Дата изменения'),
			'active' => tc('Статус'),
		);
	}

	public function search(){
		$criteria=new CDbCriteria;
		$lang = Yii::app()->language;
		$criteria->compare($this->getTableAlias().'.id', $this->id);
		$criteria->compare($this->getTableAlias().'.id_category', $this->id_category);
		
		$criteria->compare($this->getTableAlias().".title_{$lang}", $this->{'title_'.$lang}, true);
		
		$criteria->with = array('catalog', 'category');
		
		return new CustomActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
				'defaultOrder' => $this->getTableAlias().'.sorter ASC',
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
				->from('{{catalog_sub_category}}')
				->queryScalar();
			$this->sorter = $maxSorter+1;
		}
		return parent::beforeSave();
	}

	public function beforeDelete() {
		$sql = "UPDATE {{catalog}} SET id_sub_category=0, active=0 WHERE id_sub_category=".$this->id;
		Yii::app()->db->createCommand($sql)->execute();

		return parent::beforeDelete();
	}


	public static function getActiveSubCategories() {
		if(self::$_activeCatalogSubCategories === null){
			$results = Yii::app()->db->createCommand()
				->select('id, title_'.Yii::app()->language.' as title')
				->from('{{catalog_sub_category}}')
				->where('active = 1')
				->order('sorter ASC')
				->queryAll();

			self::$_activeCatalogSubCategories = CHtml::listData($results, 'id', 'title');
		}
		return self::$_activeCatalogSubCategories;
	}

	public static function getAllSubCategories() {
		if(self::$_catalogSubCategories === null){
			$results = Yii::app()->db->createCommand()
				->select('id, title_'.Yii::app()->language.' as title')
				->from('{{catalog_sub_category}}')
				->order('sorter ASC')
				->queryAll();

			self::$_catalogSubCategories = CHtml::listData($results, 'id', 'title');
		}
		return self::$_catalogSubCategories;
	}

	public static function getSubCatIdUrl($catid, $title) {
		return Yii::app()->createUrl('/catalog/main/index', array(
			'subcatid' => $catid,
			'title' => CHtml::encode($title),
		));
	}

	public static function getSubCategoryArray($category = 0, $type=0){

		if ($type != 4) {
			$sql = 'SELECT id, title_'.Yii::app()->language.' as title FROM {{catalog_sub_category}} WHERE id_category = :category ORDER BY sorter ASC';
			$res = Yii::app()->db->createCommand($sql)->queryAll(true, array(':category' => $category));
		} else {
			$sql = 'SELECT id, title_'.Yii::app()->language.' as title FROM {{catalog_sub_category}} ORDER BY sorter ASC';
			$res = Yii::app()->db->createCommand($sql)->queryAll();
		}

		$res = CHtml::listData($res, 'id', 'title');

		switch ($type) {
			case 1:
			case 4:
				$areas = CArray::merge(array(0 => ''), $res);
				break;
			case 2:
				$areas = CArray::merge(array(0 => 'Любая'), $res);
				break;
			case 3:
				$areas = CArray::merge(array(0 => 'Не выбрано'), $res);
				break;
			default :
				$areas = $res;
		}


		return $areas;
	}
}