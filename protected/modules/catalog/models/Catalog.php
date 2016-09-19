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


class Catalog extends ParentModel {
	public $path = 'webroot.uploads.catalog';
	const EMPTY_IMG = 'no_image_catalog.png';

	const KEEP_THUMB_PROPORTIONAL = true;
	const KEEP_PHOTO_PROPORTIONAL = true;

	const UPLOAD_DIR = 'uploads';
	const CATALOG_DIR = 'catalog';

	const MODIFIED_IMG_DIR = 'modified';
	const ORIGINAL_IMG_DIR = 'original';

	public $supportExt = 'jpg, png, gif';
	public $supportExtForUploader = 'jpg|png|gif';
	public $fileMaxSize = 2097152; /* 1024 * 1024 * 2 - 2 MB */

	public function init() {
		$fileMaxSize['postSize'] = toBytes(ini_get('post_max_size'));
		$fileMaxSize['uploadSize'] = toBytes(ini_get('upload_max_filesize'));

		$this->fileMaxSize = min($fileMaxSize);
		parent ::init();
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{catalog}}';
	}

	public function rules(){
		return array(
//			array(
//				'img', 'file',
//				'types' => "{$this->supportExt}",
//				'maxSize' => $this->fileMaxSize,
//				'tooLarge' => 'Максимальный размер файла: '.$this->fileMaxSize.' байт (4 МБ)',
//				'allowEmpty' => true,
//			),
		    array('id_category, '. (param('useTwoLevelCatalog', 0) ? 'id_sub_category' : ''), 'required'),
			array('title, description, cost', 'i18nRequired'),
			array('active, id_category, '. (param('useTwoLevelCatalog', 0) ? 'id_sub_category' : ''), 'numerical', 'integerOnly'=>true),
		    array('title, cost', 'i18nLength', 'max'=>255),
			array($this->getI18nFieldSafe(), 'safe'),
		    array('id_category, title, date_updated, '. (param('useTwoLevelCatalog', 0) ? 'id_sub_category' : ''), 'safe', 'on'=>'search'),
		);
	}
	
	public function i18nFields(){
        return array(
            'title' => 'varchar(255) not null',
            'description' => 'text not null',
			'cost' => 'varchar(255) not null',
			'seo_title' => 'varchar(255) not null',
			'seo_keywords' => 'text not null',
			'seo_description' => 'text not null',
        );
    }

	public function relations() {
		$relations = array(
			'catalogCategory' => array(self::BELONGS_TO, 'CatalogCategory', 'id_category',
				'condition' => 'catalogCategory.active=1'),

			'catalogImages' => array(self::HAS_MANY, 'CatalogImages', 'pid',
				'on' => 'catalogImages.active = '.  CatalogImages::STATUS_ACTIVE,
				'order' => 'catalogImages.sorter ASC',),
		);

		if (param('useTwoLevelCatalog', 0)) {
			$relations['catalogSubCategory'] = array(self::BELONGS_TO, 'CatalogSubCategory', 'id_sub_category',
				'condition' => 'catalogSubCategory.active=1');
		}

		return $relations;
	}

	public function attributeLabels(){
		return array(
			'ID' => tc('ID'),
			'id_category' => tc('Категория'),
			'id_sub_category' => tc('Подкатегория'),
			'title' => tc('Название'),
			'description' => tc('Описание'),
			'cost' => tc('Цена'),
			'img' => tc('Изображение'),
			'date_updated' => tc('Дата обновления'),
			'active' => tc('Статус'),
			'seo_title' => tc('Title страницы (для SEO)'),
			'seo_keywords' => tc('Keywords страницы (для SEO)'),
			'seo_description' => tc('Description страницы (для SEO)'),
		);
	}

	public function getMainImage(){
		if($this->catalogImages){
			$images = array();
			foreach ($this->catalogImages as $item) {
				$images[] = $item;
			}
			reset($images);
			return current($images);
		}
		return null;
	}

	public function getAllImages() {
		if($this->catalogImages){
			$images = array();
			foreach ($this->catalogImages as $item) {
				$images[] = $item;
			}
			return $images;
		}
		return null;
	}

	public function search(){
		$criteria=new CDbCriteria;
		$lang = Yii::app()->language;
		
		$criteria->compare($this->getTableAlias().".title_{$lang}", $this->{'title_'.$lang}, true);
		$criteria->compare($this->getTableAlias().".cost_{$lang}", $this->{'cost_'.$lang}, true);
		$criteria->compare($this->getTableAlias().'.id_category', $this->id_category);

		$with = array('catalogCategory', 'catalogImages');
		
		if (param('useTwoLevelCatalog', 0)) {
			$with = CMap::mergeArray($with, array('catalogSubCategory'));
			$criteria->compare($this->getTableAlias().'.id_sub_category', $this->id_sub_category);
		}
		
		$criteria->with = $with;
		
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
				'createAttribute' => 'date_updated',
				'updateAttribute' => 'date_updated',
			),
		);
	}

	public function beforeSave(){
		if($this->isNewRecord){
			$this->active = 1;

			$maxSorter = Yii::app()->db->createCommand()
				->select('MAX(sorter) as maxSorter')
				->from('{{catalog}}')
				->queryScalar();
			$this->sorter = $maxSorter+1;
		}
		return parent::beforeSave();
	}

	public function beforeDelete() {
		$sql = 'SELECT img FROM {{catalog_images}} WHERE pid="'.$this->id.'"';
		$images = Yii::app()->db->createCommand($sql)->queryAll();

		if ($images && is_array($images)) {
			foreach ($images as $image) {
				if ($image['img']) {
					$names = array(
						'thumb_*x*_'.$image['img'],
						'full_'.$image['img'],
					);

					foreach($names as $name){
						$mask = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.
							self::UPLOAD_DIR.DIRECTORY_SEPARATOR.
							self::CATALOG_DIR.DIRECTORY_SEPARATOR.
							self::MODIFIED_IMG_DIR.DIRECTORY_SEPARATOR.$name;
						@array_map( "unlink", glob( $mask ) );
					}

					@unlink(Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.
						self::UPLOAD_DIR.DIRECTORY_SEPARATOR.
						self::CATALOG_DIR.DIRECTORY_SEPARATOR.
						self::ORIGINAL_IMG_DIR.DIRECTORY_SEPARATOR.$image['img']);
				}
			}
		}
		return parent::beforeDelete();
	}

	public function afterDelete() {
		$sql = 'DELETE FROM {{catalog_images}} WHERE pid="'.$this->id.'"';
		Yii::app()->db->createCommand($sql)->execute();
		return parent::afterDelete();
	}

	public function getAllWithPagination($inCriteria = null){
		if($inCriteria === null){
			$criteria=new CDbCriteria;
			$criteria->addCondition('t.active = 1');
			$criteria->order = 't.sorter ASC';
		} else {
			$criteria = $inCriteria;
		}

		$pages = new CPagination($this->count($criteria));
		$pages->pageSize = param('module_catalog_itemsPerPage', 6);
		$pages->applyLimit($criteria);

		$items = $this->findAll($criteria);

		return array(
			'items' => $items,
			'pages' => $pages,
		);
	}

	public static function getRandomItems() {
		if (param('useTwoLevelCatalog', 0)) {
			$randomItems = Yii::app()->db->createCommand()
				->select('a.id, a.title_'.Yii::app()->language.' as title, a.description_'.Yii::app()->language.' as description, a.cost_'.Yii::app()->language.' as cost, c.img')
				->from('{{catalog}} a')
				->join('{{catalog_category}} b', 'a.id_category = b.id')
				->join('{{catalog_sub_category}} d', 'a.id_sub_category = d.id')
				->join('{{catalog_images}} c', 'c.pid = a.id')
				->where('a.active = 1 AND b.active = 1 AND d.active = 1 AND c.active = 1 AND c.sorter = 1')
				->order('RAND()')
				->limit('3')
				->queryAll();
		}
		else {
		$randomItems = Yii::app()->db->createCommand()
			->select('a.id, a.title_'.Yii::app()->language.' as title, a.description_'.Yii::app()->language.' as description, a.cost_'.Yii::app()->language.' as cost, c.img')
			->from('{{catalog}} a')
			->join('{{catalog_category}} b', 'a.id_category = b.id')
			->join('{{catalog_images}} c', 'c.pid = a.id')
			->where('a.active = 1 AND b.active = 1 AND c.active = 1 AND c.sorter = 1')
			->order('RAND()')
			->limit('3')
			->queryAll();
		}

		return $randomItems;
	}

	public function getUrl() {
		return Yii::app()->createUrl('/catalog/main/view', array(
			'id' => $this->id,
			'title' => $this->title,
		));
	}

	public static function getItemUrl($id, $title) {
		return Yii::app()->createUrl('/catalog/main/view', array(
			'id' => $id,
			'title' => CHtml::encode($title),
		));
	}

	public static function getThumb($img, $width, $height){
		if (is_object($img) && get_class($img) == 'CatalogImages') {
			$img = $img->img;
		}

		$path = Yii::getPathOfAlias('webroot.'.self::UPLOAD_DIR.'.'.self::CATALOG_DIR);
		$filePath = $path.DIRECTORY_SEPARATOR.self::MODIFIED_IMG_DIR.DIRECTORY_SEPARATOR.'thumb_'.$width.'x'.$height."_".$img;
		$fileName = 'thumb_'.$width.'x'.$height."_".$img;
		if(file_exists($filePath)){
			return $fileName;
		} else {
			$image = new CImageHandler();
			if ($img && file_exists($path.DIRECTORY_SEPARATOR.self::ORIGINAL_IMG_DIR.DIRECTORY_SEPARATOR.$img)) {
				if($image->load($path.DIRECTORY_SEPARATOR.self::ORIGINAL_IMG_DIR.DIRECTORY_SEPARATOR.$img)){
					$image->thumb($width, $height)
						->save($filePath);
					return $fileName;
				} else {
					return null;
				}
			}
			else {
				return self::returnEmptyImgUrl($width, $height);
			}
		}
	}

	public static function returnEmptyImgUrl($width, $height){
		$uploadPath = Yii::getPathOfAlias('webroot.'.self::UPLOAD_DIR);
		$fileName = $width.'x'.$height.'_'.self::EMPTY_IMG;
		if(file_exists($uploadPath.DIRECTORY_SEPARATOR.$fileName)){
			return Yii::app()->request->getBaseUrl().'/'.self::UPLOAD_DIR.'/'.$fileName;
		} else {
			$origFileName = self::EMPTY_IMG;
			if(file_exists($uploadPath.DIRECTORY_SEPARATOR.$origFileName)){
				$img = new CImageHandler();
				if(!$img->load($uploadPath.DIRECTORY_SEPARATOR.$origFileName)){
					return '';
				}
				$img->thumb($width, $height, self::KEEP_THUMB_PROPORTIONAL)
					->save($uploadPath.DIRECTORY_SEPARATOR.$fileName);
				return Yii::app()->request->getBaseUrl().'/'.self::UPLOAD_DIR.'/'.$fileName;
			} else {
				return '';
			}
		}
	}
}