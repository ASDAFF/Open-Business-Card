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

class langFieldWidget extends CWidget {
	public $model;
	public $modelName;
	public $field;

	public $type = 'string';

	public $htmlOption;

	public $useTranslate = false;
	private $fieldIdArr = array();
	private $_activeLang;

	public $row_id = '';

	private static $_publishAsset;

	public $useCopyButton = true;

	public $note;

	private $uniqueKey;

	public function getViewPath($checkTheme=false){
		return Yii::getPathOfAlias('application.modules.lang.views');
	}

	public function run() {
		$this->modelName = get_class($this->model);

		$this->uniqueKey = rand(1, 99999);

		$this->_activeLang = Lang::getActiveLangs(true);

		$countActiveLang = count($this->_activeLang);

		if ($countActiveLang <= 1 || in_array($this->type, array('text-editor'))) {
			$this->useTranslate = false;
		}
		if ($countActiveLang <= 1) {
			$this->useCopyButton = false;
		}

		if (($this->useTranslate || $this->useCopyButton) && !isset(self::$_publishAsset)) {
			self::$_publishAsset = true;
			$this->publishAssets();
		}

		$postfix = '_' . $this->uniqueKey . $this->field;

		if(count($this->_activeLang) == 1){
			$first = reset($this->_activeLang);
			$fieldCurrent = $this->field . '_' . $first['name_iso'];
			echo $this->genContentTab($fieldCurrent, $first['name_iso']);
			return;
		}
		
		// Генерим массив и контент табов
		$i = 1;
		$activeI = 1;
		foreach ($this->_activeLang as $lang) {			
			$fieldCurrent = $this->field . '_' . $lang['name_iso'];			
			$tabs['tabs']['tab' . $i . $postfix] = array(
				'title' => '<img src="' . Yii::app()->getBaseUrl() . Lang::FLAG_DIR . $lang['flag_img'] . '">&nbsp;' . $lang['name'],
				'content' => $this->genContentTab($fieldCurrent, $lang['name_iso'])
			);
			if ($lang['name_iso'] == Yii::app()->language) {
				$activeI = $i;
			}
			$i++;
		}
		$tabs['activeTab'] = 'tab' . $activeI . $postfix;

		$this->widget('CTabView', $tabs);
	}

	private function genContentTab($field, $lang) {
		$isCKEditor = ($this->type == 'text-editor') ? 1 : 0;
		
		$fieldId = 'id_' . $this->modelName . $this->field . '_' . $lang;

		$html = '';

		if ($this->useTranslate) {
			$html .= '<div class="translate_button" >';
			$html .= '<span class="t_loader_' . $this->modelName . $this->field . '" style="display: none;"><img src="' . Yii::app()->request->baseUrl . '/img/ajax-loader.gif" alt="Переводим"></span>';
			$html .= CHtml::button(tc('Перевести'), array(
				'onClick' => "translateField('{$this->field}', '{$lang}', '{$isCKEditor}', '" . $this->modelName . "')"
			));
			$html .= '</div>';
		}

		if ($this->useCopyButton) {
			$html .= '<div class="copylang_button">';
			$html .= CHtml::button(tc('Скопировать во все языки'), array(
				'onClick' => "copyField('{$this->field}', '{$lang}', '{$isCKEditor}', '" . $this->modelName . "')"
			));
			$html .= '</div>';
		}

		$html .= '<div class="rowold">';
		$html .= CHtml::activeLabel($this->model, $this->field, array('required' => $this->model->isLangAttributeRequired($this->field)));

		if ($this->note) {
			$html .= CHtml::tag('p', array('class' => 'note'), $this->note);
		}

		switch ($this->type) {
			case 'string':
				$html .= CHtml::activeTextField($this->model, $field, array(
					'class' => 'width500',
					'maxlength' => 255,
					'id' => $fieldId
				));
				break;

			case 'text':
				$html .= CHtml::activeTextArea($this->model, $field, array(
					'class' => 'width500 height200',
					'id' => $fieldId
				));
				break;

			case 'text-editor':
				$html .= '<div class="clear"></div>';

				$filebrowserImageUploadUrl = '';
				$allowedContent = false;

				if (Yii::app()->user->getState('isAdmin')) { // if admin - enable upload image
					$filebrowserImageUploadUrl = Yii::app()->createAbsoluteUrl('/site/uploadimage', array('type' => 'imageUpload', Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken));
					$allowedContent = true;
				}

				$html .= $this->widget('application.extensions.editMe.widgets.ExtEditMe', array(
					'model' => $this->model,
					'attribute' => $field,
					'toolbar' => array(
						array('Source', '-', 'Bold', 'Italic', 'Underline', 'Strike'),
						array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'),
						array('NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'),
						array('Styles', 'Format', 'Font', 'FontSize', 'TextColor', 'BGColor'),
						array('Image', 'Link', 'Unlink', 'SpecialChar'),
					),
					'allowedContent' => $allowedContent,
					'filebrowserImageUploadUrl' => $filebrowserImageUploadUrl,
					'htmlOptions' => array('id' => $fieldId)
				), true);
				break;
		}

		$html .= CHtml::error($this->model, $field);
		$html .= '</div>';

		$this->fieldIdArr[$lang] = $fieldId;

		return $html;
	}

	public function publishAssets() {
		$assets = dirname(__FILE__) . '/../assets';
		$baseUrl = Yii::app()->assetManager->publish($assets);

		if (is_dir($assets)) {
			Yii::app()->clientScript->registerCoreScript('jquery');
			Yii::app()->clientScript->registerScript(__CLASS__, "
			var activeLang = " . CJavaScript::encode(Lang::getActiveLangs()) . ";
			var baseUrl = '" . Yii::app()->request->baseUrl . "';
			var errorNoFromLang = '" . tc('Введите значение для данного языка') . "';
			var errorTranslate = '" .tc('Ошибка перевода') . "';
			var successTranslate = '" . tc('Успешный перевод') . "';
			var successCopy = '" . tc('Успешно скопировано') . "';
		", CClientScript::POS_END);

			Yii::app()->clientScript->registerScriptFile($baseUrl . '/translate.js', CClientScript::POS_END);
		} else {
			throw new Exception(Yii::t('common', 'Lang - Error: Couldn\'t find assets folder to publish.'));
		}
	}

}