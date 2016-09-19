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
	public $modelName = 'InfoPages';

	public function actionCreate(){
		$model = new $this->modelName;

		$this->performAjaxValidation($model);

		if(isset($_POST[$this->modelName])){
			$model->attributes=$_POST[$this->modelName];
			if($model->save()){
				//$this->redirect(array('view','id'=>$model->id));
				$this->redirect(array('admin'));
			}
		}

		$this->render('create', array('model'=>$model));
	}

	public function actionUpdate($id){
		$model = $this->loadModel($id);

		$this->performAjaxValidation($model);

		if(isset($_POST[$this->modelName])){
			$model->attributes=$_POST[$this->modelName];
			if($model->save()){
				//$this->redirect(array('view','id'=>$model->id));
				$this->redirect(array('admin'));
			}
		}

		$this->render('update', array('model'=>$model));
	}

	public function actionDelete($id){
		if($id == InfoPages::MAIN_PAGE_ID){
			Yii::app()->user->setFlash('error', 'Данный пункт меню является системным, и его нельзя удалить. Но вы можете отключить его в столбце "Включено".');
			$this->redirect('admin');
		}

		if (Yii::app()->cache->get('menu'))
			Yii::app()->cache->delete('menu');

		parent::actionDelete($id);
	}
}