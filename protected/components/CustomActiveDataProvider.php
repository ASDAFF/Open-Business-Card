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

class CustomActiveDataProvider extends CActiveDataProvider {
	private $_pagination;

    public function getPagination() {
        if ($this->_pagination === null) {

            $this->_pagination = new CustomPagination;
            if (($id = $this->getId()) != '')
                $this->_pagination->pageVar = $id . '_page';
        }
        return $this->_pagination;
    }
}