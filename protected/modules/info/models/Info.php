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


class Info extends ParentModel {
	const TYPE_STOCK = 1;
	const TYPE_ABOUT = 2;
	const TYPE_ERROR404 = 3;
	const TYPE_SLOGAN = 4;

	private static $_type_arr;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{info}}';
	}

	public function rules() {
		return array(
			array('description', 'i18nRequired'),
			array($this->getI18nFieldSafe(), 'safe'),
			array('type', 'safe', 'on' => 'search'),
		);
	}
	
	public function i18nFields(){
        return array(
            'description' => 'text not null',
        );
    }

	public function attributeLabels() {
		return array(
			'id' => tc('ID'),
			'type' => tc('Тип'),
			'description' => tc('Текст'),
			'date_updated' => tc('Дата обновления'),
			'active' => tc('Статус'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;
		$lang = Yii::app()->language;
		$criteria->compare("description_{$lang}", $this->{'description_'.$lang}, true);
		$criteria->compare('active', $this->active, true);

		return new CustomActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array(
				'defaultOrder' => 'id ASC',
			),
			/*'pagination' => array(
				'pageSize' => param('adminPaginationPageSize', 20),
			),*/
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
		}
		return parent::beforeSave();
	}

	public static function getTypeArray(){
		return array(
			self::TYPE_STOCK => tc('Акция'),
			self::TYPE_ABOUT => tc('О нас'),
			self::TYPE_ERROR404 => tc('Страница 404'),
			self::TYPE_SLOGAN => tc('Слоган'),
		);
	}

	public static function getTypeName($id) {
		if(!isset(self::$_type_arr)){
            self::$_type_arr = self::getTypeArray();
        }
        return self::$_type_arr[$id];
	}

	public static function getInfo($type) {
		if ($type) {
			$info = Yii::app()->db->createCommand()
				->select('description_'.Yii::app()->language.' as description')
				->from('{{info}}')
				->where('active = 1 AND type = '.$type.'')
				->limit('1')
				->queryRow();

			if ($info && isset($info['description']))
				return $info['description'];
			return false;
		}
		return false;
	}
}