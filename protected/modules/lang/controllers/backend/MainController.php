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
	public $modelName = 'Lang';

    public function actionAdmin(){
   		$this->getMaxSorter();
		$this->getMinSorter();
   		parent::actionAdmin();
   	}

    public function actionIndex(){
        $this->redirect('admin');
    }

    public function actionView($id){
        $this->redirect('admin');
    }

	public function actionSetDefault(){
        $id = (int) Yii::app()->request->getPost('id');
        $model = Lang::model()->findByPk($id);
        $model->setDefault();

        Yii::app()->end();
    }

	public function actionActivate(){
		if(demo()){
            throw new CException(tc('Извините, данное действие запрещено на демонстрационном сервере.'));
        }
		
        $id = (int) $_GET['id'];
        $action = $_GET['action'];
        if($id){
            $model = Lang::model()->findByPk($id);
            if(($model->main == 1) && $action != 'activate'){
                Yii::app()->end();
            }
        }
        parent::actionActivate();
    }

	public function actionDelete($id) {
		if(demo()){
            throw new CException(tc('Извините, данное действие запрещено на демонстрационном сервере.'));
        }
		
		parent::actionDelete($id);
	}
}
