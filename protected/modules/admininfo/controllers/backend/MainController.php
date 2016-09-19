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

class MainController extends ModuleAdminController {
	public $modelName = 'User';

	public function actionIndex(){

		$model=$this->loadModel(Yii::app()->user->id);

		if(isset($_POST[$this->modelName])){
			$model->scenario = 'changeAdminInfo';

			$model->old_password = $_POST[$this->modelName]['old_password'];
			if($model->validatePassword($model->old_password)){
				if(demo()){
					Yii::app()->user->setFlash('error', tc('Sorry, this action is not allowed on the demo server.'));
					$this->redirect(array('index'));
				}
				
				$model->attributes=$_POST[$this->modelName];
				if($model->validate()){
					if ($model->password && $model->password_repeat) {
						$model->setPassword();
					}
					else {
						$model->password = $model->old_password;
						$model->setPassword();
					}

					$model->save(false);
					Yii::app()->user->setFlash('success', 'Данные успешно изменены');
					$this->redirect(array('index'));
				}
			} else {
				Yii::app()->user->setFlash('error', 'Неверный текущий пароль');
				$this->redirect(array('index'));
			}
		}
		$this->render('index', array('model' => $model));
	}
}