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
	public $modelName = 'ConfigurationModel';
	public $defaultAction='admin';

	public function actionView($id){
		$this->redirect(array('admin'));
	}

    public function actionAdmin(){
		$this->rememberPage();

        $model = new ConfigurationModel('search');
        $model->setRememberScenario('config_remember');

        $this->render('admin',
			array_merge(array('model'=>$model), $this->params)
		);
    }

    public function actionActivate(){
        $id = intval(Yii::app()->request->getQuery('id', 0));

        if($id){
            $action = Yii::app()->request->getQuery('action');
            $model = $this->loadModel($id);

            if($model){
                $model->value = ($action == 'activate' ? 1 : 0);
                $model->update(array('value'));
            }
			
			Yii::app()->cache->flush();
        }
        if(!Yii::app()->request->isAjaxRequest){
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    public function getSections($withAll = 1){
        $sql = 'SELECT section FROM {{configuration}} GROUP BY section';
        $categories = Yii::app()->db->createCommand($sql)->queryAll();



        if($withAll)
            $return['all'] = 'Все';
        foreach($categories as $category){
            $return[$category['section']] = $category['section'];
        }
        return $return;
    }
}
