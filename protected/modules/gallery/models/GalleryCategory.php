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


class GalleryCategory extends ParentModel {
	private static $_galleryCategories;
	private static $_activeGalleryCategories;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{gallery_category}}';
	}

	public function relations() {
        return array(
			'gallery' => array(self::HAS_MANY, 'Gallery', 'id_category',
				'on' => 'gallery.active = 1',
				'order' => 'gallery.sorter ASC',
			),
		);
	}

	public function rules(){
		return array(
		    array('title', 'i18nRequired'),
		    array('title', 'i18nLength', 'min'=>2, 'max'=>255),
			array($this->getI18nFieldSafe(), 'safe'),
		    array('title, id', 'safe', 'on'=>'search'),
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
		$lang = Yii::app()->language;
		$criteria=new CDbCriteria;
		
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
				->from('{{gallery_category}}')
				->queryScalar();
			$this->sorter = $maxSorter+1;
		}
		return parent::beforeSave();
	}

	public function beforeDelete() {
		$sql = "UPDATE {{gallery}} SET id_category=0, active=0 WHERE id_category=".$this->id;
        Yii::app()->db->createCommand($sql)->execute();

		return parent::beforeDelete();
	}


	public static function getActiveCategories() {
		if(self::$_activeGalleryCategories === null){
            $results = Yii::app()->db->createCommand()
			->select('id, title_'.Yii::app()->language.' as title')
			->from('{{gallery_category}}')
			->where('active = 1')
			->order('sorter ASC')
			->queryAll();

			self::$_activeGalleryCategories = CHtml::listData($results, 'id', 'title');
        }
        return self::$_activeGalleryCategories;
	}

	public static function getAllCategories($returnArray = false) {
		if ($returnArray) {
			$results = Yii::app()->db->createCommand()
				->select('id, title_'.Yii::app()->language.' as title')
				->from('{{gallery_category}}')
				->order('sorter ASC')
				->queryAll();

			$resArr = array();
			if ($results && is_array($results)) {
				/*foreach ($results as $key => $val) {
					$resArr[$val['id']] = $val['title'];
				}

				$resArr = CJavaScript::encode($resArr);*/

				foreach($results as $key => $val) {
					$resArr[] = CHtml::tag(
						'option',
						array('value'=>$val['id']),
						CHtml::encode($val['title']),
						true
					);
				}

				return $resArr;
			}
		}
		else {
			if(self::$_galleryCategories === null){
				$results = Yii::app()->db->createCommand()
				->select('id, title_'.Yii::app()->language.' as title')
				->from('{{gallery_category}}')
				->order('sorter ASC')
				->queryAll();

				self::$_galleryCategories = CHtml::listData($results, 'id', 'title');
			}
			return self::$_galleryCategories;
		}
	}

	public static function getCategoryNameById($id) {
		if ($id) {
			if(self::$_galleryCategories === null){
				self::$_galleryCategories = self::getAllCategories();
			}
			return self::$_galleryCategories[$id];
		}
		return false;
	}

	public static function getCatIdUrl($catid, $title) {
		return Yii::app()->createUrl('/gallery/main/index', array(
			'catid' => $catid,
			'title' => CHtml::encode($title),
		));
	}
}