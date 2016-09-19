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

class langSelectorWidget extends CWidget {
	public $type = 'dropdown';
	public $languages;

	public function getViewPath($checkTheme=false){
		return Yii::getPathOfAlias('application.modules.lang.views');
	}

	public function run()
	{
		$this->render('langSelectorFormWidget', array(
				'currentLang' => Yii::app()->language,
				'languages' => ($this->languages) ? $this->languages : Lang::getActiveLangs(true),
				'type' => $this->type
			)
		);
	}
}