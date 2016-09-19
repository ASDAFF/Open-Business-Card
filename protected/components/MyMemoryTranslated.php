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

class MyMemoryTranslated {
	private $_errors = "";

	public function _construct() {
		if (!function_exists('curl_init')) {
			$this->_errors = "No CURL support";
		}
	}

	public function translateText($text, $fromLanguage = "en", $toLanguage = "ru", $translit = false) {
		$text = strip_tags($text);
		
		if (mb_strlen($text) < 500) {
			$result = getRemoteDataInfo("http://mymemory.translated.net/api/get?q=".urlencode($text)."&langpair={$fromLanguage}|{$toLanguage}");
			
			if ($result) {
				$result = CJSON::decode($result);

				if (!empty($result) && isset($result['responseStatus']) && $result['responseStatus'] == 200 && isset($result['responseData'])) {
					return $result['responseData']['translatedText'];
				}
			}
		}
		
		return false;
	}
}

?>