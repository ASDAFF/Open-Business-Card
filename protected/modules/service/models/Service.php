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

class Service extends ParentModel {
	const SERVICE_ID = 1;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{service}}';
	}

	public function rules() {
		return array(
			array('page, is_offline, allow_ip', 'safe'),
		);
	}

	public function attributeLabels() {
		return array(
			'id' => tc('ID'),
			'page' => tc('Страница'),
			'is_offline' => tc('Закрыт на обслуживание'),
			'allow_ip' => tc('Открыт для IP'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;
		$criteria->compare('page', $this->page, true);
		$criteria->compare('is_offline', $this->is_offline, true);

		return new CustomActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array(
				'defaultOrder' => 'date_created DESC',
			),
			'pagination' => array(
				'pageSize' => param('adminPaginationPageSize', 20),
			),
		));
	}
}