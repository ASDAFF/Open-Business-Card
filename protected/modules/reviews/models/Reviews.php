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

class Reviews extends ParentModel {
	public $dateCreatedFormat;
	public $verifyCode;

	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 0;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{reviews}}';
	}

	public function rules(){
		return array(
			array('name, body'.(Yii::app()->user->isGuest ? ', verifyCode' : ''), 'required'),
			array('name', 'length', 'min'=>2, 'max'=>255),
			array('body' , 'length', 'min'=>2),
			array('body, name','filter','filter'=>array(new CHtmlPurifier(),'purify')),
			array('id, name, body, date_created, date_updated', 'safe', 'on'=>'search'),
			array('verifyCode', 'captcha', 'allowEmpty'=>!Yii::app()->user->isGuest),
		);
	}

	public function attributeLabels(){
		return array(
			'name' => tc('Имя'),
			'body' => tc('Отзыв'),
			'date_created' => tc('Дата добавления'),
			'date_updated' => tc('Дата обновления'),
			'active' => tc('Статус'),
			'verifyCode' => tc('Проверочный код'),
		);
	}

	public function search(){
		$criteria=new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('body', $this->body, true);
		$criteria->compare('active', $this->active);

		//$criteria->order = 'sorter ASC';
		return new CustomActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
				'defaultOrder' => 'date_created DESC',
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
				'createAttribute' => 'date_created',
				'updateAttribute' => 'date_updated',
			),
		);
	}

	public function beforeSave(){
		if($this->isNewRecord){
			$this->active = self::STATUS_ACTIVE;
			if (!Yii::app()->user->getState('isAdmin'))
				$this->active = self::STATUS_INACTIVE;

			$maxSorter = Yii::app()->db->createCommand()
				->select('MAX(sorter) as maxSorter')
				->from('{{reviews}}')
				->queryScalar();
			$this->sorter = $maxSorter+1;
		}
		return parent::beforeSave();
	}

	public function afterFind() {
		$dateFormat = param('reviewsModule_dateFormat', 0) ? param('reviewsModule_dateFormat') : 'd.m.Y';
		$this->dateCreatedFormat = Yii::app()->dateFormatter->format(Yii::app()->locale->getDateFormat('long'), CDateTimeParser::parse($this->date_created, 'yyyy-MM-dd hh:mm:ss'));

		parent::afterFind();
	}

	public function getUrl(){
		return Yii::app()->createAbsoluteUrl('/reviews/main/view', array(
			'id'=>$this->id,
		));
	}

	public static function getCacheDependency(){
		return new CDbCacheDependency('SELECT MAX(date_updated) FROM {{reviews}}');
	}

	public static function getLastReview() {
		$criteria = new CDbCriteria();

		$criteria->condition = 'active = '.self::STATUS_ACTIVE;;
		$criteria->limit = 1;
		$criteria->order = 'date_created DESC';

		$lastReview = Reviews::model()->find($criteria);
		return $lastReview;
	}

	public static function getCountModeration(){
		$sql = "SELECT COUNT(id) FROM {{reviews}} WHERE active=".self::STATUS_INACTIVE;
		return (int) Yii::app()->db->createCommand($sql)->queryScalar();
	}
}