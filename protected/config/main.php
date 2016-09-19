<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

require_once( dirname(__FILE__) . '/../helpers/common.php');
require_once( dirname(__FILE__) . '/../helpers/strings.php');

Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');
Yii::setPathOfAlias('editable', dirname(__FILE__).'/../extensions/x-editable');

$config = array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Open Business Card',
	'sourceLanguage' => 'en',
	'language' => 'en',
	'preload'=>array(
		'log',
		'configuration', // preload configuration
	),
	'onBeginRequest' => array('BeginRequest', 'startUpdating'),

	// autoloading model and component classes
	'import'=>array(
		'editable.*',
		'application.models.*',
		'application.components.*',
		'application.helpers.*',
		'application.extensions.image.Image',
		'application.modules.configuration.components.*',
		'application.modules.menumanager.models.Menu',
		'application.modules.news.models.News',
		'application.modules.info.models.Info',
		'application.modules.contactform.models.ContactForm',
		'application.modules.articles.models.Articles',
		'application.modules.gallery.models.Gallery',
		'application.modules.price.models.Price',
		'application.modules.price.models.PriceCategory',
		'application.modules.catalog.models.Catalog',
		'application.modules.catalog.models.CatalogCategory',
		'application.modules.catalog.models.CatalogImages',
		'application.components.behaviors.ERememberFiltersBehavior',
		'application.components.Notifier.Notifier',
		'application.modules.antispam.components.MathCCaptchaAction',
		'application.modules.catalog.models.CatalogSubCategory',
		'application.modules.service.models.Service',
		'application.modules.reviews.models.*',
		'application.modules.gallery.models.GalleryCategory',
		'application.modules.infopages.models.InfoPages',
		'application.modules.lang.models.Lang',
		'application.modules.translateMessage.models.TranslateMessage',
	),

	'modules'=>array(
		'configuration',
		'admin',
		'admininfo',
		'menumanager',
		'news',
		'info',
		'contactform',
		'articles',
		'gallery',
		'price',
		'catalog',
		'install',
		'antispam',
		'service',
		'reviews',
		'infopages',
		'lang',
		'translateMessage',

		// uncomment the following to enable the Gii tool
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths'=>array(
                'bootstrap.gii', // since 0.9.1
            ),
		),
		*/
	),

	'controllerMap' => array(
		'min'=>array(
			'class'=>'ext.minScript.controllers.ExtMinScriptController',
		),
	),

	// application components
	'components'=>array(
		//X-editable config
		'editable' => array(
			'class'     => 'editable.EditableConfig',
			'form'      => 'bootstrap',        //form style: 'bootstrap', 'jqueryui', 'plain'
			'mode'      => 'popup',            //mode: 'popup' or 'inline'
			'defaults'  => array(              //default settings for all editable elements
				'emptytext' => 'Click to edit'
			)
		),
		'configuration' => array(
			'class' => 'Configuration',
			'cachingTime' => 0, // caching time
		),
		'cache'=>array(
			'class'=>'system.caching.CFileCache',
		),
		'request'=>array(
			'class' => 'application.components.CustomHttpRequest',
			'enableCsrfValidation'=>true,
		),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			'class'=>'application.components.UrlManager',
		),
		'mailer' => array(
			'class' => 'application.extensions.YiiMailer.YiiMailer',
		),
		'errorHandler'=>array(
			'errorAction'=>YII_DEBUG ? null : 'site/error',
		),
		'messages'=>array(
			'class'=>'DbMessageSource',
			'forceTranslation'=>true,
            'onMissingTranslation' => array('CustomEventHandler', 'handleMissingTranslation'),
		),

		'messagesInFile'=>array(
			'class'=>'CPhpMessageSource',
			'forceTranslation'=>true,
		),		
		/*'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
					'ipFilters'=>array('127.0.0.1'),
				),
			),
		),*/
		'bootstrap'=>array(
			'class'=>'bootstrap.components.Bootstrap', // assuming you extracted bootstrap under extensions
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		'useMinify' => true,
		'dateFormat' => 'd.m.Y H:i:s',
		'reviewsModule_dateFormat' => 'd.m.Y',
	),
);

$addons['components'] = array(
	'session' => array(
		'class' => 'CDbHttpSession',
		'connectionID' => 'db',
		'sessionTableName' => '{{users_sessions}}',
		'autoCreateSessionTable' => false, //!!!
	),
	'clientScript'=>array(
		'class' => 'ext.minScript.components.ExtMinScript',
		'minScriptLmCache' => (YII_DEBUG) ? 0 : 3600,
		'minScriptDisableMin' => array(
			'/[-\.]min\.(?:js|css)$/i', 
			'/bootstrap.js$/i', 
			'/jquery.js$/i', 
			'/ckeditor.js$/i', 
			'/[-\.]pack\.(?:js|css)$/i', 
			/*'/jquery.yiigridview.js$/i',
			'/habraalert.js$/i',
			'/jquery.prettyPhoto.js$/i',
			'/onload.js$/i',
			'/adminCommon.js$/i',*/
		),
	),
);

$addons['import'] = array(
	'application.modules.configuration.models.ConfigurationModel',
);

if(obcInstall::isInstalled()){
	$config = CMap::mergeArray($config, $addons);
}

$db = require(dirname(__FILE__) . '/db.php');
if($db === 1){
	$db = array();
}

return CMap::mergeArray($config, $db);