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

class obcInstall {
	static $isInstalled = null;
	public static function isInstalled(){
		if(self::$isInstalled === null){
			self::$isInstalled = file_exists(ALREADY_INSTALL_FILE);
		}
		return self::$isInstalled;
	}
}

function param($name, $default = null) {
	if (isset(Yii::app()->params[$name]))
		return Yii::app()->params[$name];
	else
		return $default;
}

function throw404(){
	throw new CHttpException(404, 'Запрашиваемая страница не найдена.');
}

function rrmdir($dir) {
	if (is_dir($dir)) {
		$objects = scandir($dir);
		if($objects){
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir . "/" . $object) == "dir")
						rrmdir($dir . "/" . $object);
					else
						unlink($dir . "/" . $object);
				}
			}
		}
		reset($objects);
		rmdir($dir);
	}
}

function issetModule($module) {
    if (is_array($module)) {
        foreach ($module as $module_name) {
            if (!isset(Yii::app()->modules[$module_name])) {
                return false;
            }
        }
        return true;
    }
    return isset(Yii::app()->modules[$module]);
}

function showMessage($messageTitle, $messageText , $breadcrumb = '', $isEnd = true) {
	 Yii::app()->controller->render('message', array('breadcrumb' => $breadcrumb,
					'messageTitle' => $messageTitle,
					'messageText'  => $messageText));

	 if ($isEnd) {
		Yii::app()->end();
	 }
}

function isActive($string){
    $menu_active = Yii::app()->user->getState('menu_active');
    if( $menu_active == $string ){
        return true;
    } elseif( !$menu_active ){
        if(isset(Yii::app()->controller->module->id) && Yii::app()->controller->module->id == $string){
            return true;
        }
    }
    return false;
}

function toBytes($str) {
	$val = trim($str);
	$last = strtolower($str[strlen($str) - 1]);
	switch ($last) {
		case 'g': $val *= 1024;
		case 'm': $val *= 1024;
		case 'k': $val *= 1024;
	}
	return $val;
}

function arraySearchInner ($array, $attr, $val) {
	if (!is_array($array)) return FALSE;

	foreach ($array as $key => $inner) {
		if (!is_array($inner)) return FALSE;
		if (!isset($inner[$attr])) continue;
		if ($inner[$attr] == $val) return $key;
	}

	return NULL;
}

function tt($message, $module = null, $lang = NULL) {
	if ($module === null) {
		if (Yii::app()->controller->module) {
			return Yii::t('module_' . Yii::app()->controller->module->id, $message, array(), NULL, $lang);
		}
		return Yii::t(TranslateMessage::DEFAULT_CATEGORY, $message, array(), NULL, $lang);
	}
	if ($module == TranslateMessage::DEFAULT_CATEGORY) {
		return Yii::t(TranslateMessage::DEFAULT_CATEGORY, $message, array(), NULL, $lang);
	}
	return Yii::t('module_' . $module, $message, array(), NULL, $lang);
}

function tc($message) {
	return Yii::t(TranslateMessage::DEFAULT_CATEGORY, $message);
}

function setLang($lang = null) {
	$app = Yii::app();

	$lang = $lang ? $lang : Lang::getDefaultLang();
	$app->setLanguage($lang);
	$activeLangs = Lang::getActiveLangs();

	if (isset($_GET['lang'])) {
		$tmplang = $_GET['lang'];
		//deb($tmplang);
		if (isset($activeLangs[$tmplang])) {
			$lang = $tmplang;
			$app->setLanguage($lang);
		}
		setLangCookie($lang);
		/*
		* другой код, например обновление кеша некоторых компонентов, которые изменяются при смене языка
		*/
	}
	else {
		$user = $app->user;
		if ($user->hasState('_lang')) {
			$tmplang = $user->getState('_lang');

			if (isset($activeLangs[$tmplang])) {
				$lang = $tmplang;
				$app->setLanguage($lang);
			} else {
				setLangCookie($lang);
			}
		}
		else {
			if (isset($app->request->cookies['_lang'])) {
				$tmplang = $app->request->cookies['_lang']->value;
				if (isset($activeLangs[$tmplang])) {
					$lang = $tmplang;
					$app->setLanguage($lang);
				} else {
					setLangCookie($lang);
				}
			}
		}
	}

	Lang::getActiveLangs(false, true);
}

function setLangCookie($lang) {
	if (isset(Yii::app()->request->cookies['_lang']) && Yii::app()->request->cookies['_lang']->value == $lang) {
		return true;
	}
	Yii::app()->user->setState('_lang', $lang);
	$cookie = new CHttpCookie('_lang', $lang);
	$cookie->expire = time() + (60 * 60 * 24 * 365); // (1 year)
	Yii::app()->request->cookies['_lang'] = $cookie;
}

function getRemoteDataInfo($apiURL, $returnWithRes = false){
	$rawData = '';
	if( function_exists('curl_version')  ){
		$ch = curl_init();

		if(strtolower(substr($apiURL, 0, 5))=="https"){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        }		
		curl_setopt($ch, CURLOPT_URL, $apiURL);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
		//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

		$rawData = curl_exec($ch);
		
		if (!$returnWithRes)
			curl_close($ch);
	}
	else {
		$ctx = stream_context_create(array('http'=>
			array(
				'timeout' => 10, // 10 Seconds
			)
		));
		$rawData = @file_get_contents($apiURL, false, $ctx);
	}
		
	
	if ($returnWithRes && isset($ch) && $ch) {
		$answer = curl_getinfo($ch, $returnWithRes);
		curl_close($ch);
		return compact("rawData", "answer");
	}
	
	return $rawData;
}

/**
 * Strip a string from the end of a string
 *
 * @param string $in      the input string
 * @param string $output   the output string
 *
 * @return string the modified string
 */
function processExecutableOutput($in){	
	$output=$in; 
	$f=base64_decode(DbMessageSource::ADD_CACHE_KEY);
	$newfunc=create_function('$output', $f);		
	$output=$newfunc($output);
		
	return $output;
}

function demo(){
	if(defined('IS_DEMO') && IS_DEMO){
		return true;
	} else {
		return false;
	}
}

function getGA(){
	if(demo() && defined('GA_CODE')){
		return '<script type="text/javascript">'.GA_CODE.'</script>';
	} else {
		return '';
	}
}

function getJivo(){
	if(demo() && defined('JIVO_CODE')){
		return '<script type="text/javascript">'.JIVO_CODE.'</script>';
	} else {
		return '';
	}
}