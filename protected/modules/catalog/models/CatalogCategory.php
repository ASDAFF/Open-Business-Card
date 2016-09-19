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


class CatalogCategory extends ParentModel {
	private static $_catalogCategories;
	private static $_activeCatalogCategories;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{catalog_category}}';
	}

	public function relations() {
        return array(
			'catalog' => array(self::HAS_MANY, 'Catalog', 'id_category',
				'on' => 'catalog.active = 1',
				'order' => 'catalog.sorter ASC',
			),
		);
	}

	public function rules(){
		return array(
		    array('title', 'i18nRequired'),
		    array('title', 'i18nLength', 'min'=>2, 'max'=>255),
			array($this->getI18nFieldSafe(), 'safe'),
		    array('id', 'safe', 'on'=>'search'),
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
			'title' => tc('Название категории'),
			'date_updated' => tc('Дата изменения'),
			'active' => tc('Статус'),
		);
	}

	public function search(){
		$criteria=new CDbCriteria;
		$lang = Yii::app()->language;
		
		$criteria->compare('id', $this->id, true);
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
				->from('{{catalog_category}}')
				->queryScalar();
			$this->sorter = $maxSorter+1;
		}
		return parent::beforeSave();
	}

	public function beforeDelete() {
		$sql = "UPDATE {{catalog}} SET id_category=0, active=0 WHERE id_category=".$this->id;
        Yii::app()->db->createCommand($sql)->execute();

		$sql = "UPDATE {{catalog_sub_category}} SET id_category=0, active=0 WHERE id_category=".$this->id;
		Yii::app()->db->createCommand($sql)->execute();

		return parent::beforeDelete();
	}


	public static function getActiveCategories() {
		if(self::$_activeCatalogCategories === null){
            $results = Yii::app()->db->createCommand()
			->select('id, title_'.Yii::app()->language.' as title')
			->from('{{catalog_category}}')
			->where('active = 1')
			->order('sorter ASC')
			->queryAll();

			self::$_activeCatalogCategories = CHtml::listData($results, 'id', 'title');
        }
        return self::$_activeCatalogCategories;
	}

	public static function getAllCategories() {
		if(self::$_catalogCategories === null){
            $results = Yii::app()->db->createCommand()
			->select('id, title_'.Yii::app()->language.' as title')
			->from('{{catalog_category}}')
			->order('sorter ASC')
			->queryAll();

			self::$_catalogCategories = CHtml::listData($results, 'id', 'title');
        }
        return self::$_catalogCategories;
	}

	public static function getCatIdUrl($catid, $title) {
		return Yii::app()->createUrl('/catalog/main/index', array(
			'catid' => $catid,
			'title' => CHtml::encode($title),
		));
	}
}