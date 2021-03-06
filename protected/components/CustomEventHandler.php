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

class CustomEventHandler {
    static function handleMissingTranslation($event) {
        if( in_array($event->category, array('YiiDebug.yii-debug-toolbar', 'yii-debug-toolbar')) ){
            return false;
        }
        TranslateMessage::missingTranslation($event->category, $event->message);
    }
}