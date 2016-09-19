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

class fieldEditor extends CWidget {
	public $modelName;
	public $model;
	public $field;
	public $type = 'text-editor';

	public function run() {
		$this->modelName = get_class($this->model);
		$fieldId = 'id_' . $this->modelName . $this->field;

		switch ($this->type) {
			case 'text-editor':				
				$filebrowserImageUploadUrl = '';
				$allowedContent = false;

				if (Yii::app()->user->getState('isAdmin')) { // if admin - enable upload image
					$filebrowserImageUploadUrl = Yii::app()->createAbsoluteUrl('/site/uploadimage', array('type' => 'imageUpload', Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken));
					$allowedContent = true;
				}

				echo $this->widget('application.extensions.editMe.widgets.ExtEditMe', array(
					'model' => $this->model,
					'attribute' => $this->field,
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
	}
}