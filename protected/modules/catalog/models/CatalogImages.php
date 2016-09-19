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


class CatalogImages extends CActiveRecord {
	public $WorkItemsSelected;

	const STATUS_INACTIVE = 0;
	const STATUS_ACTIVE = 1;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{catalog_images}}';
	}

	public function rules() {
		return array(
			array('pid, img', 'required'),
			array('pid', 'numerical', 'integerOnly' => true),
			array('id, pid, img', 'safe', 'on' => 'search'),
		);
	}

	public function relations() {
		return array(
			'catalog' => array(self::BELONGS_TO, 'Catalog', 'pid'),
		);
	}

	public function attributeLabels() {
		return array(
			'id' => tc('ID'),
			'pid' => tc('ID позиции(наименования)'),
			'img' => tc('Изображение'),
			'active' => tc('Статус'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('pid', $this->pid);
		$criteria->compare('active', $this->active, true);

		return new CustomActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array(
				'defaultOrder' => 'sorter ASC',
			),
			'pagination' => array(
				'pageSize' => param('adminPaginationPageSize', 20),
			)
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
			$maxSorter = Yii::app()->db->createCommand()
				->select('MAX(sorter) as maxSorter')
				->from('{{catalog_images}}')
				->where('pid = "'.$this->pid.'"')
				->queryRow();
			$this->sorter = $maxSorter['maxSorter']+1;
		}
		return parent::beforeSave();
	}

	public function afterDelete(){
        if(isset($this->sorter)){
            $sql = "SELECT id FROM ".$this->tableName()." WHERE pid = '".$this->pid."' ORDER BY sorter ASC";
            $ids = Yii::app()->db->createCommand($sql)->queryColumn();
            $i = 1;
            foreach($ids as $id){
                $sql = "UPDATE ".$this->tableName()." SET sorter=$i WHERE id=$id";
                Yii::app()->db->createCommand($sql)->execute();
                $i++;
            }
        }
        return parent::afterDelete();
    }

	public function beforeDelete() {
		if ($this->img) {
			$names = array(
				'thumb_*x*_'.$this->img,
				'full_'.$this->img,
			);

			foreach($names as $name){
				$mask = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.
					Catalog::UPLOAD_DIR.DIRECTORY_SEPARATOR.
					Catalog::CATALOG_DIR.DIRECTORY_SEPARATOR.
					Catalog::MODIFIED_IMG_DIR.DIRECTORY_SEPARATOR.$name;
				@array_map( "unlink", glob( $mask ) );
			}

			@unlink(Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.
				Catalog::UPLOAD_DIR.DIRECTORY_SEPARATOR.
				Catalog::CATALOG_DIR.DIRECTORY_SEPARATOR.
				Catalog::ORIGINAL_IMG_DIR.DIRECTORY_SEPARATOR.$this->img);
		}
		return parent::beforeDelete();
	}
}