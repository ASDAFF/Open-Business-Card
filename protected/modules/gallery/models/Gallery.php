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


class Gallery extends ParentModel {
	public $path = 'webroot.uploads.gallery';
	const EMPTY_IMG = 'no_image_gallery.png';

	const KEEP_THUMB_PROPORTIONAL = true;
	const KEEP_PHOTO_PROPORTIONAL = true;

	const UPLOAD_DIR = 'uploads';
	const GALLERY_DIR = 'gallery';

	const MODIFIED_IMG_DIR = 'modified';
	const ORIGINAL_IMG_DIR = 'original';

	public $img;
	public $dateCreated;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{gallery}}';
	}
	
	public function i18nFields(){
        return array(
            'description' => 'text not null',
        );
    }

	public function rules() {
		if (param('useGalleryGategory', 0)) {
			return array(
				array('id_category', 'required'),
				array('img', 'safe'),
				array('id_category, img', 'safe', 'on'=>'search'),
				array($this->getI18nFieldSafe(), 'safe'),
			);
		}
		return array(
			array('img', 'safe'),
			array($this->getI18nFieldSafe(), 'safe'),
		);
	}

	public function relations() {
		if (param('useGalleryGategory', 0)) {
			return array(
				'galleryCategory' => array(self::BELONGS_TO, 'GalleryCategory', 'id_category',
					'condition' => 'galleryCategory.active=1'),
			);
		}
		return array();
	}

	public function attributeLabels() {
		return array(
			'id' => tc('ID'),
			'img' => tc('Изображение'),
			'id_category' => tc('Категория'),
			'description' => tc('Описание'),
			'date_created' => tc('Дата добавления'),
			'dateCreated' => tc('Дата обновления'),
			'active' => tc('Статус'),
			'sorter' => tc('Порядок'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;
		$lang = Yii::app()->language;
		
		$criteria->compare($this->getTableAlias().".description_{$lang}", $this->{'description_'.$lang}, true);
		$criteria->compare($this->getTableAlias().'.id', $this->id);
		$criteria->compare($this->getTableAlias().'.active', $this->active, true);

		if (param('useGalleryGategory', 0))
			$criteria->compare($this->getTableAlias().'.id_category', $this->id_category);

		return new CustomActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array(
				'defaultOrder' => 'sorter ASC',
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

			$maxSorter = Yii::app()->db->createCommand()
				->select('MAX(sorter) as maxSorter')
				->from('{{gallery}}')
				->queryRow();
			$this->sorter = $maxSorter['maxSorter']+1;
		}
		return parent::beforeSave();
	}

	public function beforeDelete() {
		if (isset($this->img) && $this->img) {

			$names = array(
				'thumb_*x*_'.$this->img,
				'full_'.$this->img,
			);

			foreach($names as $name){
				$mask = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.
					self::UPLOAD_DIR.DIRECTORY_SEPARATOR.
					self::GALLERY_DIR.DIRECTORY_SEPARATOR.
					self::MODIFIED_IMG_DIR.DIRECTORY_SEPARATOR.$name;
				@array_map( "unlink", glob( $mask ) );
			}

			@unlink(Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.
				self::UPLOAD_DIR.DIRECTORY_SEPARATOR.
				self::GALLERY_DIR.DIRECTORY_SEPARATOR.
				self::ORIGINAL_IMG_DIR.DIRECTORY_SEPARATOR.$this->img);
		}

		return parent::beforeDelete();
	}

	public function afterFind() {
		$dateFormat = param('dateFormat', 'd.m.Y H:i:s');
		$this->dateCreated = date($dateFormat, strtotime($this->date_created));

		return parent::afterFind();
	}

	public function getAllWithPagination($inCriteria = null, $userMode = false){
		if($inCriteria === null){
			$criteria = new CDbCriteria;
			$criteria->addCondition('active = 1');
			$criteria->order = 'sorter ASC';
		} else {
			$criteria = $inCriteria;
		}

		$pages = new CPagination($this->count($criteria));
		if (!$userMode)
			$pages->pageSize = param('adminPaginationPageSize', 20);
		else
			$pages->pageSize = param('module_gallery_itemsPerPage', 6);

		$pages->applyLimit($criteria);

		$items = $this->findAll($criteria);

		return array(
			'items' => $items,
			'pages' => $pages,
		);
	}

	public function getThumb($width, $height){
		$path = Yii::getPathOfAlias($this->path);
		$filePath = $path.DIRECTORY_SEPARATOR.self::MODIFIED_IMG_DIR.DIRECTORY_SEPARATOR.'thumb_'.$width.'x'.$height."_".$this->img;
		$fileName = 'thumb_'.$width.'x'.$height."_".$this->img;
		if(file_exists($filePath)){
			return $fileName;
		} else {
			$image = new CImageHandler();
			if($image->load($path.DIRECTORY_SEPARATOR.self::ORIGINAL_IMG_DIR.DIRECTORY_SEPARATOR.$this->img)){
				$image->thumb($width, $height)
					->save($filePath);
				return $fileName;
			} else {
				return null;
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