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


class UrlManager extends CUrlManager{
	private $langRoute;
    private $isInstalled = false;
	private $_myRules = array();
	private $_replaceSymb = array(',', '/','!','#','~','@','%','^','&', '?','/','\\','|','-', '+', '.', ' ', '--');
	private $langs;
	private $defaultLang;

	public function init(){
		if (!in_array(Yii::app()->language, Lang::getActiveLangsNameISO())) {
			Yii::app()->setLanguage(Lang::getDefaultLang());
		}
		
		$this->langs = Lang::getActiveLangs();
		$this->defaultLang = Lang::getDefaultLang();
		$this->isInstalled = obcInstall::isInstalled();
		
		$keyDefault = array_search($this->defaultLang, $this->langs);
		if($keyDefault !== false && $this->isInstalled && count($this->langs) > 1){
			unset($this->langs[$keyDefault]);
		}
		
		$this->langRoute = '<lang:'.implode('|',$this->langs).'>';
		
		########################################################################		
		$this->_myRules = array(
			array(
				'replace' => array(
					'<title:.*?>',
					'<id:\d+>',
					'news',
				),
				'route' => 'news/main/view',
				'pattern' => param('module_news_seoPattern', '::text/::title-::id.html'),
				'isIgnore' => false,
			),
			array(
				'replace' => array(
					'<title:.*?>',
					'<id:\d+>',
					'articles',
				),
				'route' => 'articles/main/view',
				'pattern' => param('module_articles_seoPattern', '::text/::title-::id.html'),
				'isIgnore' => false,
			),
			array(
				'replace' => array(
					'<title:.*?>',
					'<catid:\d+>',
					'catalog/category',
				),
				'route' => 'catalog/main/index',
				'pattern' => param('module_catalog_seoPattern', '::text/::title-::catid.html'),
				'isCategory' => true,
				'isIgnore' => false,
			),
			array(
				'replace' => array(
					'<title:.*?>',
					'<subcatid:\d+>',
					'catalog/subcategory',
				),
				'route' => 'catalog/main/index',
				'pattern' => param('module_catalog_seoPattern', '::text/::title-::subcatid.html'),
				'isSubCategory' => true,
				'isIgnore' => (!param('useTwoLevelCatalog', 0)) ? true : false,
			),
			array(
				'replace' => array(
					'<title:.*?>',
					'<id:\d+>',
					'catalog',
				),
				'route' => 'catalog/main/view',
				'pattern' => param('module_catalog_seoPattern', '::text/::title-::id.html'),
				'isIgnore' => false,
			),
			array(
				'replace' => array(
					'<title:.*?>',
					'<catid:\d+>',
					'gallery/category',
				),
				'route' => 'gallery/main/index',
				'pattern' => param('module_gallery_seoPattern', '::text/::title-::catid.html'),
				'isCategory' => true,
				'isIgnore' => (!param('useGalleryGategory', 0)) ? true : false,
			),
			array(
				'replace' => array(
					'<title:.*?>',
					'<id:\d+>',
					'page',
				),
				'route' => 'infopages/main/view',
				'pattern' => param('module_infopages_seoPattern', '::text/::title-::id.html'),
				'isIgnore' => false,
			),
		);

		$this->parseSeoInitRules();
		
		########################################################################
		$rulesLang = array();
		$rules = array(
			'site/uploadimage/' => 'site/uploadimage/',
			'min/serve/g/' => 'min/serve/',
			'<module:\w+>/backend/<controller:\w+>/<action:\w+>'=>'<module>/backend/<controller>/<action>', // CGridView ajax
		);
				
		$rulesLang = array(
			'/' => 'site/index',
			'/admin' => 'site/login',
			'/login' => 'site/login',
			'/logout' => 'site/logout',

			'/news'=>'news/main/index',
			'/articles'=>'articles/main/index',
			'/gallery'=>'gallery/main/index',
			'/catalog'=>'catalog/main/index',
			'/price'=>'price/main/index',
			'/contact'=>'contactform/main/index',
			'/reviews' => '/reviews/main/index',
			'/reviews/add' => '/reviews/main/add',
			'/search' => 'site/search',
			'/site/uploadimage/' => 'site/uploadimage/',
			'/min/serve/g/' => 'min/serve/',	
		);

		foreach($rulesLang as $key => $rule){
			if($this->langs && $this->langRoute){
				$rules[$this->langRoute . $key] = $rule;
			}
           	$rules[$key] = array($rule, 'defaultParams' => array('lang' => $this->defaultLang));
        }
		
		if($this->langs && $this->langRoute){
			$rules[$this->langRoute] = '';
		}
		$this->addRules($rules);
		
		parent::init();
	}

	public function parseSeoInitRules(){
		if(!$this->_myRules){
			return;
		}
		
		$langs = Lang::getActiveLangs();
		
		if($this->langs && $this->langRoute){
			foreach($this->_myRules as $rule){
				if (!$rule['isIgnore']) {						
					$seoPattern = $this->parseSeoLink($rule['replace'], $rule['pattern'], (isset($rule['isCategory'])) ? true : false, (isset($rule['isSubCategory'])) ? true : false);

					if($seoPattern){
						$this->rules[$this->langRoute .'/'. $seoPattern] = $rule['route'];
						$this->addRules(array(
							$this->langRoute .'/'. $seoPattern => $rule['route'],
						));
						
						
						$this->rules[$seoPattern] = array($rule['route'], 'defaultParams' => array('lang' => $this->defaultLang));
						$this->addRules(array(
							$seoPattern => array($rule['route'], 'defaultParams' => array('lang' => $this->defaultLang)),
						));
					}					
				}
			}
		}
	}

    public function createUrl($route,$params=array(),$ampersand='&'){		
		if ($route != 'min/serve' && $route != 'site/uploadimage') {
			$langs = Lang::getActiveLangs();
            $countLangs = count($langs);
            $defaultLang = Lang::getDefaultLang();

			if(isset($params['lang']) && $params['lang'] == $defaultLang && $this->isInstalled){
				if(!param('useBootstrap')){
					unset($params['lang']);
				}
			} else if (Yii::app()->language != $defaultLang && empty($params['lang']) && $countLangs > 1) {
				$params['lang'] = Yii::app()->language;
			}

			if(!$this->isInstalled && $countLangs == 1 && $route != 'install'){
				$params['lang'] = Yii::app()->language;
			}

			if(!$this->isInstalled && $countLangs > 1 && !isset($params['lang']) && $route != 'install'){
				$params['lang'] = Yii::app()->language;
			}
		}
		
		if($this->_replaceSymb && isset($params['title'])){
			$params['title'] = str_replace($this->_replaceSymb, '-', $params['title']);
			//$params['title'] = mb_strtolower($params['title'], 'UTF-8');

			if (param('useUrlTranslit', false))
				$params['title'] = self::translit($params['title']);
		}
		
		return parent::createUrl($route, $params, $ampersand);
    }

	private function parseSeoLink($replaceTo = array(), $seoPattern = '', $isCategory = false, $isSubCategory = false){
		if($replaceTo){
			if($seoPattern){
				if ($isCategory) {
					$seoPattern = str_replace(array(
						'::title',
						'::catid',
						'::text',
					), $replaceTo, $seoPattern);
				}
				elseif ($isSubCategory) {
					$seoPattern = str_replace(array(
						'::title',
						'::subcatid',
						'::text',
					), $replaceTo, $seoPattern);
				}
				else {
					$seoPattern = str_replace(array(
						'::title',
						'::id',
						'::text',
					), $replaceTo, $seoPattern);
				}
				return $seoPattern;
			}
		}
		return false;
	}

	public function translit($text){
		$tr = array(
			"Є" => "YE", "І" => "I", "Ѓ" => "G", "і" => "i", "№" => "#", "є" => "ye", "ѓ" => "g",
			"А" => "A", "Б" => "B", "В" => "V", "Г" => "G", "Д" => "D",
			"Е" => "E", "Ё" => "YO", "Ж" => "ZH",
			"З" => "Z", "И" => "I", "Й" => "J", "К" => "K", "Л" => "L",
			"М" => "M", "Н" => "N", "О" => "O", "П" => "P", "Р" => "R",
			"С" => "S", "Т" => "T", "У" => "U", "Ф" => "F", "Х" => "X",
			"Ц" => "C", "Ч" => "CH", "Ш" => "SH", "Щ" => "SHH", "Ъ" => "'",
			"Ы" => "Y", "Ь" => "", "Э" => "E", "Ю" => "YU", "Я" => "YA",
			"а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d",
			"е" => "e", "ё" => "yo", "ж" => "zh",
			"з" => "z", "и" => "i", "й" => "j", "к" => "k", "л" => "l",
			"м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
			"с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "x",
			"ц" => "c", "ч" => "ch", "ш" => "sh", "щ" => "shh", "ъ" => "",
			"ы" => "y", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya", "«" => "", "»" => "", "—" => "-"
		);

		$urlstr = trim($text);
		$urlstr = strtr($urlstr,$tr);
		$urlstr = strtolower($urlstr);
		$urlstr = preg_replace('/[^\w\d\-]/', '-', $urlstr);
		return preg_replace('/\-{2,}/', '-', $urlstr);
	}
}