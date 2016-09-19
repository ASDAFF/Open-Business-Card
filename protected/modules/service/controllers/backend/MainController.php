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
	public $modelName = 'Service';

	public function actionUpdate($id) {
		$this->redirect('admin');
	}

	public function actionDelete($id) {
		$this->redirect('admin');
	}

	public function actionCreate() {
		$this->redirect('admin');
	}

    public function actionAdmin(){
		$model = $this->loadModel(Service::SERVICE_ID);
		$this->performAjaxValidation($model);

		if(isset($_POST[$this->modelName])){
			$model->attributes=$_POST[$this->modelName];
			if($model->save()){
				Yii::app()->user->setFlash('success', tc('Успешно сохранено.'));
			}
			else
				Yii::app()->user->setFlash('error', tc('Ошибка сохранения. Пожалуйста, повторите попытку позже.'));
		}

		$this->render('update', array('model' => $model));
    }
	
	public function actionDoClear() {
		if (Yii::app()->request->isAjaxRequest) {
			$target = Yii::app()->request->getParam('target');

			$text = '';
			if(in_array($target, array('assets', 'runtime'))) {
				$cacheDir = '';
				switch ($target) {
					case 'assets':
						$cacheDir = Yii::app()->assetManager->basePath;
						break;
					case 'runtime':
						$cacheDir = Yii::app()->runtimePath;
						
						Yii::app()->cache->flush();
						break;
				}
				
				if ($cacheDir && is_dir($cacheDir)) {
					$excludeFiles = array('.empty', /* 'state.bin', */ 'already_install');				
					$excludeDirs = array('cache', 'HTML', 'minScript', 'URI');
					
					$this->rrmdir($cacheDir, $excludeFiles, $excludeDirs);
					$text = '<div class="flash-success">'.Yii::t('common', 'Файлы кэша в папке {folder} были успешно удалены', array('{folder}' => $cacheDir)).'</div>';
				}
			}

			echo $text;
			Yii::app()->end();
		}
	}
	
	function rrmdir($dir, $excludeFiles = array(), $excludeDirs = array(), $depth = 0) {
		if (is_dir($dir)) {
			$objects = scandir($dir);
			if ($objects) {
				foreach ($objects as $object) {
					if ($object != "." && $object != ".." && !in_array($object, $excludeFiles)) {
						if (filetype($dir . DIRECTORY_SEPARATOR . $object) == "dir") {
							$depth = $depth + 1;
							$this->rrmdir($dir . DIRECTORY_SEPARATOR . $object, $excludeFiles, $excludeDirs, $depth);
						}
						else {
							@unlink($dir . DIRECTORY_SEPARATOR . $object);
						}
					}
				}
			}

			reset($objects);
			if (!in_array(substr($dir, strrpos($dir, '/') + 1), $excludeDirs) && $depth)
				@rmdir($dir);
		}
	}
}