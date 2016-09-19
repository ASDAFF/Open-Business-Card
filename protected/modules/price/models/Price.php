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


class Price extends ParentModel {
	public $dateCreated;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{price}}';
	}

	public function scopes() {
		return array(
			'active'=>array(
				'condition'=>$this->getTableAlias().'.active=1',
			),
		);
	}

	public function relations() {
		return array(
			'cat' => array(self::BELONGS_TO, 'PriceCategory', 'cat_id'),
		);
	}

	public function rules() {
		return array(
			array('cat_id', 'required'),
			array('name', 'i18nRequired'),
			array('name, cost', 'i18nLength', 'max' => 255),
			array('is_bold', 'boolean'),
			array($this->getI18nFieldSafe(), 'safe'),
			array('cat_id, date_created, active, is_bold', 'safe', 'on' => 'search'),
		);
	}
	
	public function i18nFields(){
        return array(
            'name' => 'varchar(255) not null',
			'cost' => 'varchar(255) not null',
        );
    }

	public function attributeLabels() {
		return array(
			'№' => tc('№'),
			'id' => tc('ID'),
			'cat_id' => tc('Разделитель'),
			'name' => tc('Наименование'),
			'name_separator' => tc('Текст в разделителе'),
			'cost' => tc('Цена'),
			'is_bold' => tc('Выделить жирным текстом'),
			'date_created' => tc('Дата добавления'),
			'dateCreated' => tc('Дата обновления'),
			'active' => tc('Статус'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;
		$lang = Yii::app()->language;

		$criteria->compare($this->getTableAlias().'.cat_id', $this->cat_id);
		
		$criteria->compare($this->getTableAlias().".name_{$lang}", $this->{'name_'.$lang}, true);
		$criteria->compare($this->getTableAlias().".cost_{$lang}", $this->{'cost_'.$lang}, true);		
		$criteria->compare($this->getTableAlias().'.active', $this->active, true);
		$criteria->order = 'cat.sorter ASC, '.$this->getTableAlias().'.sorter ASC';

		$criteria->with = array('cat');

		return new CustomActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => /*param('adminPaginationPageSize', 20)*/ 100,
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
				->from('{{price}}')
				->queryRow();
			$this->sorter = $maxSorter['maxSorter']+1;
		}
		return parent::beforeSave();
	}

	protected function afterFind() {
		$dateFormat = param('dateFormat', 'd.m.Y H:i:s');
		$this->dateCreated = date($dateFormat, strtotime($this->date_created));

		return parent::afterFind();
	}

	public function getAll($inCriteria = null){
		if($inCriteria === null){
			$criteria = new CDbCriteria;
			$criteria->addCondition('active = 1');
			$criteria->order = 'sorter ASC';
		} else {
			$criteria = $inCriteria;
		}

		$price = $this->findAll($criteria);

		return array(
			'price' => $price,
		);
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
		$pages->pageSize = param('module_price_itemsPerPage', 50);
		$pages->applyLimit($criteria);

		$price = $this->findAll($criteria);

		return array(
			'price' => $price,
			'pages' => $pages,
		);
	}

	public function getRowCssClass(){
		return '';
	}

}