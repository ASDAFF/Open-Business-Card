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


class ConfigurationModel extends ParentModel {
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function behaviors() {
        return array(
            'ERememberFiltersBehavior' => array(
                'class' => 'application.components.behaviors.ERememberFiltersBehavior',
                'defaults'=>array(),
                'defaultStickOnClear'=>false
            ),
        );
    }

	public function tableName() {
		return '{{configuration}}';
	}

	public function rules() {
		return array(
			array('name, value', 'settingsValidator'),
			array('name, value', 'length', 'max' => 255),
			array($this->getI18nFieldSafe(), 'safe'),
		);
	}
	
	public function i18nFields(){
        return array(
            'title' => 'varchar(255) not null',
        );
    }

	public function settingsValidator() {
		$allowEmpty = array('adminPhone', 'adminSkype', 'adminICQ', 'adminAddress', 'mailSMTPSecure');
		if (!in_array($this->name, $allowEmpty) && empty($this->value)) {
			$this->addError('value', 'Заполните поле');
		}
	}

	public function attributeLabels() {
		return array(
			'title' => tc('Название'),
			'value' => tc('Значение'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;
		$lang = Yii::app()->language;
		
		$criteria->compare("title_{$lang}", $this->{'title_'.$lang}, true);
		$criteria->compare('value', $this->value, true);

        $section_filter = Yii::app()->request->getQuery('section_filter');

        if($section_filter != 'all'){
            $criteria->compare('section', $section_filter);
        }

		return new CustomActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array(
				'defaultOrder' => 'id',
			),
			'pagination' => array(
				'pageSize' => param('adminPaginationPageSize', 20),
			),
		));
	}

	public function beforeSave() {
		Configuration::clearCache();
		if ($this->isNewRecord){
			$this->date_updated = new CDbExpression('NOW()');
		}
		return parent::beforeSave();
	}

    public static function getAdminValue($model){
        if($model->type == 'bool') {
            $url = Yii::app()->controller->createUrl("activate",
                array(
                    'id' => $model->id,
                    'action' => ($model->value == 1 ? 'deactivate' : 'activate'),
                ));
            $img = CHtml::image(
                Yii::app()->request->baseUrl.'/img/'.($model->value ? '' : 'in').'active.png',
                Yii::t('common', $model->value ? 'Неактивно' : 'Активно'),
                array('title' => Yii::t('common', $model->value ? 'Деактивировать' : 'Активировать'))
            );

            $options = array(
                'onclick' => 'ajaxSetStatus(this, "config-table"); return false;',
            );

            return '<div align="left">'.CHtml::link($img, $url, $options).'</div>';
        } 
		elseif($model->type == 'enum') {
			$list = self::getEnumListForKey($model->name);
			return isset($list[$model->value]) ? $list[$model->value] : utf8_substr($model->value, 0, 55);
		}
		else {
            return utf8_substr($model->value, 0, 55);
        }
    }

    public static function getVisible($type){
        return $type == 'text' || $type == 'enum';
    }
	
	public static function getEnumListForKey($key){
		$list = array(
			'mailSMTPSecure' => array(
				'' => '',
				'tls' => 'tls',
				'ssl' => 'ssl',
			),
		);

		return isset($list[$key]) ? $list[$key] : array();
	}
}