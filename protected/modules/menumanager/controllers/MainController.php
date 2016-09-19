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

class MainController extends ModuleUserController{
	public $modelName = 'Menu';

	public function actions() {
		return array(
			'captcha' => array(
				'class' => 'MathCCaptchaAction',
				'backColor' => 0xFFFFFF,
			),
		);
	}

	public function actionIndex(){
		if(Yii::app()->user->getState("isAdmin")){
			$this->redirect(array('/menumanager/backend/main/admin'));
			return;
		}
		$this->redirect(array('/site/index'));
	}

	public function actionView($id = 0, $url = ''){
		if($url && issetModule('seo')){
			$seo = SeoFriendlyUrl::getForView($url, $this->modelName);

			if(!$seo){
				throw404();
			}

			$this->setSeo($seo);

			$id = $seo->model_id;
		}
		$model = $this->loadModel($id);

		if($model){
			if ($model->type == Menu::LINK_NEW_INFO && !isset($model->page))
				throw404 ();
			
			if(Yii::app()->request->getParam('is_ajax')){
				$this->renderPartial('/view', array('model' => $model), false, true);
			}else{
				$this->render('/view', array('model' => $model));
			}
		} else {
			Yii::app()->user->setFlash('error', 'Страница не найдена');
			$this->redirect(array('/site/index'));
		}
	}
}