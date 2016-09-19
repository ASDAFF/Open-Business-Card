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

class PriceCategory extends ParentModel {
	private static $_allCategories;

	public function scopes() {
		return array(
			'active'=>array(
				'condition'=>$this->getTableAlias().'.active=1',
			),
		);
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{price_category}}';
	}

	public function rules() {
		return array(
			array('name', 'i18nRequired'),
			array('active, sorter', 'numerical', 'integerOnly'=>true),
			array('name', 'i18nLength', 'max'=>255),
			array($this->getI18nFieldSafe(), 'safe'),
			array('id, sorter, date_updated', 'safe', 'on'=>'search'),
		);
	}

	public function i18nFields(){
        return array(
            'name' => 'varchar(255) not null',
        );
    }
	
	public function attributeLabels() {
		return array(
			'id' => tc('ID'),
			'name' => tc('Наименование'),
			'active' => tc('Статус'),
			'sorter' => tc('Сортировка'),
			'date_updated' => tc('Дата обновления'),
		);
	}

	public function search(){
		$criteria=new CDbCriteria;
		$lang = Yii::app()->language;

		$criteria->compare($this->getTableAlias().'.id', $this->id);
		$criteria->compare("name_{$lang}", $this->{'name_'.$lang}, true);
		
		$criteria->order = $this->getTableAlias().'.sorter ASC';

		return new CustomActiveDataProvider($this, array(
			'criteria'=>$criteria,
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
				'setUpdateOnCreate' => true,
			),
		);
	}

	public function relations() {
		return array(
			'price' => array(self::HAS_MANY, 'Price', 'cat_id'),
		);
	}

	public function beforeSave(){
		if($this->isNewRecord){
			$this->active = 1;

			$maxSorter = Yii::app()->db->createCommand()
				->select('MAX(sorter) as maxSorter')
				->from($this->tableName())
				->queryScalar();
			$this->sorter = $maxSorter+1;
		}

		return parent::beforeSave();
	}

	public function getAllWithPrice(){
		$criteria = new CDbCriteria;
		$criteria->addCondition('active = 1');
		$criteria->order = 'sorter ASC';
		$criteria->with = array('price');


		$price = PriceCategory::model()->active()->findAll(array(
			'with'=>array(
				'price'=>array(
					'scopes'=>array('active')
				),
			),
			'order' => $this->getTableAlias().'.sorter ASC, price.sorter ASC',
		));

		return array(
			'price' => $price,
		);
	}

	public static function getAllCategories(){
		if(self::$_allCategories === null){
			$sql = 'SELECT name_'.Yii::app()->language.' as name, id
					FROM '.self::tableName().'
					ORDER BY sorter ASC';

			$results = Yii::app()->db->createCommand($sql)->queryAll();

			self::$_allCategories = CHtml::listData($results, 'id', 'name');
		}
		return self::$_allCategories;
	}

	public function afterSave() {
		return parent::afterSave();
	}

	public function beforeDelete(){
		$sql = "UPDATE {{price}} SET cat_id = 0, active = 0 WHERE cat_id = ".$this->id;
		Yii::app()->db->createCommand($sql)->execute();

		return parent::beforeDelete();
	}

	public static function getPriceCategory($firstElement = 0, $isMerge = true){
		$criteria = new CDbCriteria;
		$criteria->condition = 'active = 1';
		$criteria->order = 'sorter ASC';

		$result = self::model()->findAll($criteria);

		$result = CHtml::listData($result, 'id', 'name');

		if ($isMerge) {
			switch ($firstElement) {
				case 1:
					$result = CMap::mergeArray(array(0 => ''), $result);
					break;
				case 2:
					$result = CMap::mergeArray(array(0 => 'любая'), $result);
					break;
				case 3:
					$result = CMap::mergeArray(array(0 => 'не выбрана'), $result);
					break;
			}
		}

		return $result;
	}

	public static function getCDbDependency () {
		return new CDbCacheDependency('SELECT MAX(date_updated) FROM '.self::tableName());
	}
}