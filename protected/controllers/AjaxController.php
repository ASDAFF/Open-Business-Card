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

class AjaxController extends Controller {

	public function init(){
		if (!Yii::app()->request->isAjaxRequest)
			return false;

		parent::init();
	}


	public function actionGetSubCat() {
		if (param('useTwoLevelCatalog', 0)) {
			$cat = (int) Yii::app()->request->getParam('id_cat', 0);
			$firstElement = (int) Yii::app()->request->getParam('firstElement', 0);

			$subCategories = CatalogSubCategory::getSubCategoryArray($cat, $firstElement);

			if ($subCategories && is_array($subCategories)) {
				foreach($subCategories as $value => $name) {
					echo CHtml::tag(
						'option',
						array('value'=>$value),
						CHtml::encode($name),
						true
					);
				}
			}
		}
	}
}