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

class CustomPagination extends CPagination {
	public function createPageUrl($controller,$page)         {
			$params=$this->params===null ? $_GET : $this->params;
	//      if($page>0) // page 0 is the default
					$params[$this->pageVar]=$page+1;
	//      else
	//              unset($params[$this->pageVar]);
			return $controller->createUrl($this->route,$params);
	}
}