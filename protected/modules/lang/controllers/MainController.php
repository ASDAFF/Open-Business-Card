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

class MainController extends ModuleUserController {
	public $modelName = 'Lang';

    public function actionAjaxTranslate(){
        if(!Yii::app()->request->isAjaxRequest)
            throw404();

        $fromLang = Yii::app()->request->getPost('fromLang');
        $fields = Yii::app()->request->getPost('fields');
		$errors = false;
		$translateField = array();
		
        if(!$fromLang || !$fields)
            throw new CException('Lang no req data');

        $translate = new MyMemoryTranslated();
        $fromVal = $fields[$fromLang];
		
        foreach($fields as $lang=>$val){
            if($lang == $fromLang)
                continue;
			
			if ($answer = $translate->translateText($fromVal, $fromLang, $lang))
				$translateField[$lang] = $answer;
			else
				$errors = true;
        }

		if ($errors) {
			echo json_encode(array(
				'result' => 'no',
				'fields' => ''
			));
		}
        else {
			echo json_encode(array(
				'result' => 'ok',
				'fields' => $translateField
			));
		}
        Yii::app()->end();
    }
}