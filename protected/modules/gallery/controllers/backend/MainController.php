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


class MainController extends ModuleAdminController{
	public $modelName = 'Gallery';

	public function actionCreate() {
		$model = new $this->modelName; // for initializing assets and publish script

		Yii::app()->user->setState('menu_active', 'gallery.create');

		if(isset($_POST['description']) || isset($_POST['id_category'])){
			if (isset($_POST['description'])) {
				foreach($_POST['description'] as $key => $value) {
					$modelGal = Gallery::model()->findByPk((int) $key);
					$langs = Lang::getActiveLangs();
					
					if (!empty($langs)) {
						foreach ($langs as $lang) {
							$modelGal->setAttributes(array('description_'.$lang => CHtml::encode($value)));
						}
						$modelGal->save(false);
					}
					//Gallery::model()->updateByPk((int) $key, array('description' => $value));
				}
			}

			if (isset($_POST['id_category']) && param('useGalleryGategory', 0)) {
				foreach($_POST['id_category'] as $key => $value) {
					Gallery::model()->updateByPk((int) $key, array('id_category' => (int) $value));
				}
			}
			$this->redirect('admin');
		}

		$this->render('create', array());
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id);

		$this->performAjaxValidation($model);

		if(isset($_POST[$this->modelName])){
			$model->attributes=$_POST[$this->modelName];
			if($model->save()){
				$this->redirect('admin');
			}
		}

		$this->render('update',
			array_merge(
				array('model'=>$model),
				$this->params
			)
		);
	}

	public function actionAdmin(){
		$this->getMaxSorter();
		$this->getMinSorter();
		$this->scenario = 'create';
		parent::actionAdmin();
	}
}