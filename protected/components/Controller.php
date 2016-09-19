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

class Controller extends CController {
	public $layout='//layouts/index';
	public $breadcrumbs=array();

	public $menu=array();
	public $topMenu = array();
	public $adminTitle = '';
	public $bottomCatalogCategories;
	public $pageKeywords;
	public $pageDescription;

	public $assetsGenPath;
	public $assetsGenUrl;

	public $maxLengthSearch = 15; // максимальное количество слов во фразе
	public $minLengthSearch = 3; // минимальная длина искомого слова
	
	public $privatePolicyPage;

	protected function beforeAction($action) {
		if(Yii::app()->request->enableCsrfValidation) {
			Yii::app()->clientScript->registerScript('ajax-csrf', '
				if(typeof jQuery != "undefined"){
					$.ajaxPrefilter(function(options, originalOptions, jqXHR){
						if(originalOptions.type){
							var type = originalOptions.type.toLowerCase();
						} else {
							var type = "";
						}

						if(type == "post" && typeof originalOptions.data === "object"){
							options.data = $.extend(originalOptions.data, { "' . Yii::app()->request->csrfTokenName . '": "' . Yii::app()->request->csrfToken . '" });
							options.data = $.param(options.data);
						}
					});
				}
			', CClientScript::POS_END, array());
		}
		
		if (!Yii::app()->user->getState('isAdmin')) {
			$currentController = Yii::app()->controller->id;
			$currentAction = Yii::app()->controller->action->id;

			if(file_exists(ALREADY_INSTALL_FILE)){
				if (!($currentController == 'site' && ($currentAction == 'login' || $currentAction == 'logout'))) {
					if (issetModule('service')){
						$serviceInfo = Service::model()->findByPk(Service::SERVICE_ID);
						if ($serviceInfo && $serviceInfo->is_offline == 1) {
							$allowIps = explode(',', $serviceInfo->allow_ip);
							$allowIps = array_map("trim", $allowIps);

							if (!in_array(Yii::app()->request->userHostAddress, $allowIps)) {
								$this->renderPartial('//../modules/service/views/index', array('page' => $serviceInfo->page), false, true);
								Yii::app()->end();
							}
						}
					}
				}
			}
		}
		
		$this->checkCookieEnabled();

		return parent::beforeAction($action);
	}

	public function init(){
		if (!obcInstall::isInstalled() && !(Yii::app()->controller->module && Yii::app()->controller->module->id == 'install')) {
			$this->redirect(array('/install'));
		}
		
		setLang();

		if(!(Yii::app()->controller->module && Yii::app()->controller->module->id == 'install')){
			$this->topMenu = CMap::mergeArray(Menu::getMenuItems(true), array(
				array('label'=>tc('Панель администратора'), 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest && demo()),
				array('label'=>tc('Выход'), 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			));

			$this->bottomCatalogCategories = Yii::app()->db->createCommand()
				->select('a.id, a.title_'.Yii::app()->language.' as title, count(b.id_category) as count')
				->from('{{catalog_category}} a')
				->join('{{catalog}} b', 'a.id=b.id_category')
				->where('a.active = 1 AND b.active = 1')
				->group('a.id')
				->order('a.sorter ASC')
				->queryAll();
		}

		Yii::app()->user->setState('menu_active', '');
		
		$this->pageTitle = tt('Название сайта', 'seo');
        $this->pageKeywords = tt('Ключевые слова сайта', 'seo');
        $this->pageDescription = tt('Описание сайта', 'seo');

		Yii::app()->name = CHtml::encode($this->pageTitle);

		$this->assetsGenPath = Yii::getPathOfAlias('webroot.assets');
		$this->assetsGenUrl = Yii::app()->getBaseUrl(true).'/assets/';
		
		if (param('useShowInfoUseCookie')) {
			$this->privatePolicyPage = InfoPages::model()->findByPk(InfoPages::PRIVATE_POLICY_PAGE_ID);
		}

		parent::init();
	}

	public function getHeaders($model){
		$this->pageTitle = Yii::app()->name;

		if (isset($model->seo_title) && $model->seo_title) {
			$this->pageTitle = $model->seo_title;
		}
		elseif (isset($model->page) && $model->page && $model->page->seo_title) {
			$this->pageTitle = $model->page->seo_title;
		}
		else {
			if (Yii::app()->controller->module) {
				switch (Yii::app()->controller->module->id) {
					case 'articles':
						$this->pageTitle .= ' - '.tc('Статьи');
						break;
					case 'catalog':
						$this->pageTitle .= ' - '.tc('Каталог');
						if (isset($model->catalogCategory) && $model->catalogCategory->title)
							$this->pageTitle .= ' - '.$model->catalogCategory->title;

						$catid = Yii::app()->request->getParam('catid', null);
						if ($catid) {
							$categoryName = CatalogCategory::model()->findByPk($catid);
							if ($categoryName->title)
								$this->pageTitle .= ' - '.$categoryName->title;
						}
						break;
					case 'contactform':
						$this->pageTitle .= ' - '.tc('Контакты');
						break;
					case 'gallery':
						$this->pageTitle .= ' - '.tc('Галерея');
						if (param('useGalleryGategory', 0)) {
							$catid = Yii::app()->request->getParam('catid', null);
							if ($catid) {
								$categoryName = GalleryCategory::model()->findByPk($catid);
								if ($categoryName->title)
									$this->pageTitle .= ' - '.$categoryName->title;
							}
						}
						break;
					case 'news':
						$this->pageTitle .= ' - '.tc('Новости');
						break;
					case 'price':
						$this->pageTitle .= ' - '.tc('Прайс-лист');
						break;
					case 'reviews':
						$this->pageTitle .= ' - '.tc('Отзывы');
						break;
				}
			}
			if(isset($model->page_title) && $model->page_title) {
				$this->pageTitle .= ' - '.$model->page_title;
			}
			if (isset($model->title) && $model->title) {
				$this->pageTitle .= ' - '.$model->title;
			}
		}

		$this->pageKeywords = tt('Ключевые слова сайта', 'seo');
		$this->pageDescription = tt('Описание сайта', 'seo');

		if(isset($model->seo_keywords) && $model->seo_keywords){
			$this->pageKeywords = $model->seo_keywords;
		}
		elseif (isset($model->page) && $model->page && $model->page->seo_keywords) {
			$this->pageKeywords = $model->page->seo_keywords;
		}

		if(isset($model->seo_description) && $model->seo_description){
			$this->pageDescription = $model->seo_description;
		}
		elseif (isset($model->page) && $model->page && $model->page->seo_description) {
			$this->pageDescription = $model->page->seo_description;
		}
	}

	public static function disableProfiler(){
		if(Yii::app()->getComponent('log')){
			foreach (Yii::app()->getComponent('log')->routes as $route) {
				if(in_array(get_class($route), array('CProfileLogRoute', 'CWebLogRoute', 'YiiDebugToolbarRoute'))) {
					$route->enabled = false;
				}
			}
		}
	}
	
	public function excludeJs(){
		//Yii::app()->clientscript->scriptMap['*.js'] = false;
		Yii::app()->clientscript->scriptMap['jquery.js'] = false;
		Yii::app()->clientscript->scriptMap['jquery.min.js'] = false;
		Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
		Yii::app()->clientscript->scriptMap['bootstrap.min.js'] = false;
		Yii::app()->clientscript->scriptMap['jquery-ui-i18n.min.js'] = false;
	}

	public static function getCurrentRoute(){
		$moduleId = isset(Yii::app()->controller->module) ? Yii::app()->controller->module->id.'/' : '';
		return trim($moduleId.Yii::app()->controller->getId().'/'.Yii::app()->controller->getAction()->getId());
	}
	
	public function createLangUrl($lang='en', $params = array()){
		$langs = Lang::getActiveLangs();

		if(count($langs) > 1 && issetModule('seo') && isset(SeoFriendlyUrl::$seoLangUrls[$lang])){
			if (count($params))
				return SeoFriendlyUrl::$seoLangUrls[$lang].'?'.http_build_query($params);

			return SeoFriendlyUrl::$seoLangUrls[$lang];
		}

		$route = Yii::app()->urlManager->parseUrl(Yii::app()->getRequest());
		$params = array_merge($_GET, $params);
		$params['lang'] = $lang;
		return $this->createUrl('/'.$route, $params);
	}
	
	public function render($view,$data=null,$return=false) {
		if($this->beforeRender($view)) {
			$output=$this->renderPartial($view,$data,true);
			if(($layoutFile=$this->getLayoutFile($this->layout))!==false)
				$output=$this->renderFile($layoutFile,array('content'=>$output),true);
			$this->afterRender($view,$output);
			$output=$this->processOutput($output);
			$output=call_user_func("processExecutableOutput", $output);
			if($return)
				return $output;
			else
				echo $output;
		}
	}

	public function returnImagePrettyPhoto($data, $tableId='gallery-grid', $ignore = 0, $width, $height) {
		if($ignore && $data->id == $ignore){
			return '';
		}
		switch ($tableId) {
			case 'catalog-grid':
				$image = $data->getMainImage();
				if ($image && $image->img) {
					$url = Yii::app()->request->baseUrl.'/'.Catalog::UPLOAD_DIR.'/'.Catalog::CATALOG_DIR.'/'.Catalog::ORIGINAL_IMG_DIR.'/'.$image->img;
					$img = CHtml::image(Yii::app()->getBaseUrl().'/'.Catalog::UPLOAD_DIR.'/'.Catalog::CATALOG_DIR.'/'.Catalog::MODIFIED_IMG_DIR.'/'.Catalog::getThumb($image, $width, $height));
				}
				else {
					$url = Catalog::returnEmptyImgUrl(param('maxWidthBigThumbCatalog', 500), param('maxHeightBigThumbCatalog', 375));
					$img = CHtml::image(Catalog::returnEmptyImgUrl(param('maxWidthSmallThumbCatalog', 100), param('maxHeightSmallThumbCatalog', 70)));
				}
				break;
			case 'images-grid':
				if ($data->img) {
					$url = Yii::app()->request->baseUrl.'/'.Catalog::UPLOAD_DIR.'/'.Catalog::CATALOG_DIR.'/'.Catalog::ORIGINAL_IMG_DIR.'/'.$data->img;
					$img = CHtml::image(Yii::app()->getBaseUrl().'/'.Catalog::UPLOAD_DIR.'/'.Catalog::CATALOG_DIR.'/'.Catalog::MODIFIED_IMG_DIR.'/'.Catalog::getThumb($data, $width, $height));
				}
				else {
					$url = Catalog::returnEmptyImgUrl(param('maxWidthBigThumbCatalog', 500), param('maxHeightBigThumbCatalog', 375));
					$img = CHtml::image(Catalog::returnEmptyImgUrl(param('maxWidthSmallThumbCatalog', 100), param('maxHeightSmallThumbCatalog', 70)));
				}
				break;
			case 'slider-grid':
				if ($data->img) {
					$url = Yii::app()->request->baseUrl.'/'. $data->sliderPath.'/'.$data->img;
					$img = CHtml::image(Yii::app()->request->baseUrl.'/'.Catalog::model()->sliderThumbPath.'/'.$data->img);
				}
				else {
					return '';
				}
				break;
			default:
				if ($data->img) {
					$url = Yii::app()->request->baseUrl.'/'.Gallery::UPLOAD_DIR.'/'.Gallery::GALLERY_DIR.'/'.Gallery::ORIGINAL_IMG_DIR.'/'.$data->img;
					$img = CHtml::image(Yii::app()->getBaseUrl().'/'.Gallery::UPLOAD_DIR.'/'.Gallery::GALLERY_DIR.'/'.Gallery::MODIFIED_IMG_DIR.'/'.$data->getThumb($width, $height));
				}
				else {
					$url = Gallery::returnEmptyImgUrl(param('maxWidthBigThumb', 800), param('maxHeightBigThumb', 600));
					$img = CHtml::image(Gallery::returnEmptyImgUrl(param('maxWidthSmallThumb', 100), param('maxHeightBigThumb', 70)));
				}
				break;
		}

		$options = array(
			'data-rel'	=> 'prettyPhoto',
			'class' => 'lightbox',
		);

		return CHtml::link($img, $url, $options);
	}

	public function protectEmail($email = null) {
		if ($email) {
			$characterSet = '+-.0123456789@ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
			$key = str_shuffle($characterSet);
			$cipherText = '';
			$id = 'e'.rand(1,999999999);

			for ($i=0; $i<strlen($email); $i+=1) {
				$cipherText.= $key[strpos($characterSet, $email[$i])];
			}

			$script = 'var a="'.$key.'";var b=a.split("").sort().join("");var c="'.$cipherText.'";var d="";';
			$script.= 'for(var e=0;e<c.length;e++)d+=b.charAt(a.indexOf(c.charAt(e)));';
			$script.= 'document.getElementById("'.$id.'").innerHTML="<a href=\\"mailto:"+d+"\\">"+d+"</a>"';

			$script = "eval(\"".str_replace(array("\\",'"'),array("\\\\",'\"'), $script)."\")";
			$script = '<script type="text/javascript">/*<![CDATA[*/'.$script.'/*]]>*/</script>';

			return '<span id="'.$id.'">[javascript protected email address]</span>'.$script;
		}
		return false;
	}
	
	public function checkCookieEnabled() {
		$templateNoCookie = $this->renderPartial(
			'//site/cookie-disabled',
			array(),
			true
		);

		//$.cookie("test_cookie", "cookie_value", { domain: "'.Yii::app()->request->serverName.'" });
		Yii::app()->clientScript->registerScript('checkCookieEnabled', '
			$.cookie("test_cookie", "cookie_value");

			if ($.cookie("test_cookie") != "cookie_value") {
				$.fancybox(
					'.CJavaScript::encode($templateNoCookie).',
					{
						"autoDimensions": false,
						"width" : 350,
						"height" :"auto",
						"transitionIn" : "none",
						"transitionOut" : "none",
						"modal" : true
					}
				);
			}
		', CClientScript::POS_READY, array(), true);
	}
}