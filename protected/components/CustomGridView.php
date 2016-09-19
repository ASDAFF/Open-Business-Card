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

Yii::import('bootstrap.widgets.TbGridView');

class CustomGridView extends TbGridView {
	//public $pager = array('class'=>'itemPaginator');
	public $template = "{summary}\n{pager}\n{items}\n{pager}";
    public $type = 'striped bordered condensed';
	public $pager = array('class'=>'bootstrap.widgets.TbPager', 'displayFirstAndLast' => true);
}