<?php $baseUrl = Yii::app()->request->baseUrl; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="language" content="en"/>
	<meta name="description" content="<?php echo CHtml::encode($this->pageDescription); ?>"/>
	<meta name="keywords" content="<?php echo CHtml::encode($this->pageKeywords); ?>"/>

	<?php
		Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/admin-styles.css');
		Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/form.css');
		Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prettyPhoto.css');
	?>

	<!--[if IE]>
	<link href="<?php echo $baseUrl; ?>/css/ie.css" rel="stylesheet" type="text/css"> <![endif]-->
	<link rel="icon" href="<?php echo $baseUrl; ?>/favicon.ico" type="image/x-icon"/>
	<link rel="shortcut icon" href="<?php echo $baseUrl; ?>/favicon.ico" type="image/x-icon"/>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body id="top">
<div id="fb-root"></div>
	<?php $otherScriptsUrl = (Yii::app()->language == 'ru') ? 'http://monoray.ru/products' : 'http://monoray.net/products'; ?>
	<?php		
	$this->widget('bootstrap.widgets.TbNavbar', array(
		'fixed' => 'top',
		'brand' => Yii::app()->name,
		'brandUrl' => $baseUrl,
		'collapse' => false, // requires bootstrap-responsive.css
		'items' => array(
			/*array(
				'class' => 'bootstrap.widgets.TbMenu',
				'items' => array(
					array('label' => tc('Панель администратора'), 'url' => '#', 'active' => true),
					//array('label' => tc('Меню'), 'url' => '#', 'items' => $this->topMenu),
				),
			),*/
			array(
				'class' => 'bootstrap.widgets.TbMenu',
				'items' => array(
					array(
						'label' => tc('Other_author_scripts'), 
						'url' => $otherScriptsUrl, 
						'linkOptions'=>array('class'=>'advert-author-scripts', 'target'=>'_blank')
					),
				),
				'encodeLabel' => false,
			),
			array(
				'class' => 'bootstrap.widgets.TbMenu',
				'htmlOptions' => array('class' => 'pull-right'),
				'items' => array(
					array('label' => tc('Выход'), 'url' => $baseUrl . '/site/logout'),
				),
			),
			array(
				'class' => 'bootstrap.widgets.TbMenu',
				'htmlOptions' => array('class' => 'pull-right'),
				'items' => array(
					array('label' => tc('Языки'), 'url' => '#', 'items' => Lang::getAdminMenuLangs())
				),
			),
		),
	));
	?>

<?php
$countReviewsModeration = Reviews::getCountModeration();
$bageReviews = ($countReviewsModeration > 0) ? "&nbsp<span class=\"badge\">{$countReviewsModeration}</span>" : '';
?>

<div class="bootnavbar-delimiter"></div>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span3">
			<div class="well sidebar-nav">
				<?php $this->widget('bootstrap.widgets.TbMenu', array(
				'type' => 'list',
				'encodeLabel' => false,
				'items' => array(
					array('label' => tc('Управление меню')),
					array('label' => tc('Управление меню'), 'icon' => 'icon-list-alt', 'url' => $baseUrl . '/menumanager/backend/main/admin', 'active' => isActive('menumanager')),
					array('label' => tc('Информационные страницы'), 'icon' => 'icon-info-sign', 'url' => $baseUrl . '/infopages/backend/main/admin', 'active' => isActive('infopages')),

					array('label' => tc('Новости')),
					array('label' => tc('Новости'), 'icon' => 'icon-align-left', 'url' => $baseUrl . '/news/backend/main/admin', 'active' => isActive('news')),
					array('label' => tc('Добавить новость'), 'icon' => 'icon-plus-sign', 'url' => $baseUrl . '/news/backend/main/create', 'active' => isActive('news.create'), 'linkOptions' => array('class' => 'lcatsub')),

					array('label' => tc('Статьи')),
					array('label' => tc('Статьи'), 'icon' => 'icon-align-center', 'url' => $baseUrl . '/articles/backend/main/admin', 'active' => isActive('articles')),
					array('label' => tc('Добавить статью'), 'icon' => 'icon-plus-sign', 'url' => $baseUrl . '/articles/backend/main/create', 'active' => isActive('articles.create'), 'linkOptions' => array('class' => 'lcatsub')),
					
					array('label' => tc('Отзывы')),
					array('label' => tc('Управление отзывами') . $bageReviews, 'icon' => 'icon-envelope', 'url' => $baseUrl . '/reviews/backend/main/admin', 'active' => isActive('reviews')),
					array('label' => tc('Добавить отзыв'), 'icon' => 'icon-plus-sign', 'url' => $baseUrl . '/reviews/backend/main/create', 'active' => isActive('reviews.create'), 'linkOptions' => array('class' => 'lcatsub')),

					array('label' => tc('Галерея')),
					array('label' => tc('Галерея'), 'icon' => 'icon-th', 'url' => $baseUrl . '/gallery/backend/main/admin', 'active' => isActive('gallery')),
                    array('label' => tc('Добавить изображение'), 'icon' => 'icon-plus-sign', 'url' => $baseUrl . '/gallery/backend/main/create', 'active' => isActive('gallery.create'), 'linkOptions' => array('class' => 'lcatsub')),
					array('label' => tc('Управление категориями'), 'icon' => 'icon-th', 'url' => $baseUrl . '/gallery/backend/gallerycategory/admin', 'active' => isActive('gallerycategory.admin'), 'visible' => param('useGalleryGategory', 0)),
					array('label' => tc('Добавить категорию'), 'icon' => 'icon-plus-sign', 'url' => $baseUrl . '/gallery/backend/gallerycategory/create', 'active' => isActive('gallerycategory.create'), 'visible' => param('useGalleryGategory', 0), 'linkOptions' => array('class' => 'lcatsub')),

					array('label' => tc('Каталог')),
					array('label' => tc('Управление категориями'), 'icon' => 'icon-align-justify', 'url' => $baseUrl . '/catalog/backend/catalogcategory/admin', 'active' => isActive('catalogcategory.admin')),
					array('label' => tc('Добавить категорию'), 'icon' => 'icon-plus-sign', 'url' => $baseUrl . '/catalog/backend/catalogcategory/create', 'active' => isActive('catalogcategory.create'), 'linkOptions' => array('class' => 'lcatsub')),
					array('label' => tc('Управление подкатегориями'), 'icon' => 'icon-align-justify', 'url' => $baseUrl . '/catalog/backend/catalogsubcategory/admin', 'active' => isActive('catalogsubcategory.admin'), 'visible' => param('useTwoLevelCatalog', 0)),
					array('label' => tc('Добавить подкатегорию'), 'icon' => 'icon-plus-sign', 'url' => $baseUrl . '/catalog/backend/catalogsubcategory/create', 'active' => isActive('catalogsubcategory.create'), 'visible' => param('useTwoLevelCatalog', 0), 'linkOptions' => array('class' => 'lcatsub')),
					array('label' => tc('Управление наименованиями'), 'icon' => 'icon-align-justify', 'url' => $baseUrl . '/catalog/backend/catalog/admin', 'active' => isActive('catalog.admin')),
					array('label' => tc('Добавить наименование'), 'icon' => 'icon-plus-sign', 'url' => $baseUrl . '/catalog/backend/catalog/create', 'active' => isActive('catalog.create'), 'linkOptions' => array('class' => 'lcatsub')),

					array('label' => tc('Прайс-лист')),
                    array('label' => tc('Прайс-лист'), 'icon' => 'icon-th-list', 'url' => $baseUrl . '/price/backend/main/admin', 'active' => isActive('price')),
					array('label' => tc('Добавить наименование'), 'icon' => 'icon-plus-sign', 'url' => $baseUrl . '/price/backend/main/create', 'active' => isActive('price.create'), 'linkOptions' => array('class' => 'lcatsub')),
					array('label' => tc('Разделители'), 'icon' => 'icon-th-list', 'url' => $baseUrl . '/price/backend/cat/admin', 'active' => isActive('price.createseparator')),

					array('label' => tc('Информация')),
					array('label' => tc('Информация'), 'icon' => 'icon-info-sign', 'url' => $baseUrl . '/info/backend/main/admin', 'active' => isActive('info')),

					array('label' => tc('Настройки')),
					array('label' => tc('Настройки'), 'icon' => 'icon-wrench', 'url' => $baseUrl . '/configuration/backend/main/admin', 'active' => isActive('configuration')),
					array('label' => tc('Данные администратора'), 'icon' => 'icon-wrench', 'url' => $baseUrl . '/admininfo/backend/main/index', 'active' => isActive('admininfo')),
					array('label' => tc('Обслуживание сайта'), 'icon' => 'icon-wrench', 'url' => $baseUrl . '/service/backend/main/admin', 'active' => isActive('service'), 'visible' => issetModule('service')),
					
					array('label' => tc('Языки')),
					array('label' => tc('Языки'), 'icon' => 'icon-globe', 'url' => $baseUrl . '/lang/backend/main/admin', 'active' => isActive('lang')),
					array('label' => tc('Переводы'), 'icon' => 'icon-pencil', 'url' => $baseUrl . '/translateMessage/backend/main/admin', 'active' => isActive('translateMessage')),
				),
			)); ?>
			</div>
			<!--/.well -->
		</div>
		<!--/span-->
		<div class="span9">
			<?php echo $content; ?>
		</div>
		<!--/span-->
	</div><!--/row-->

	<hr>

    <footer id="footer">
		<div class="wrapper">
			<p class="copyrights">
				<span class="slogan">&copy;&nbsp;<?php echo Yii::app()->name;?>,&nbsp;<?php echo date('Y'); ?></span>
			</p>
		</div>
	</footer>
	<div id="loading" style="display:none;"><?php echo tc('Загрузка содержимого ...');?></div>
<?php
	Yii::app()->clientScript->registerScript('loading', '
		$(document).ajaxSend(function(){
			$("#loading").show();
		}).ajaxComplete(function(){
			$("#loading").hide();
		});
	', CClientScript::POS_READY);
	Yii::app()->clientScript->registerCoreScript('jquery');
	Yii::app()->clientScript->registerCoreScript('jquery.ui');
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/browser_fix.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.dropdownPlain.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.prettyPhoto.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/onload.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/tooltip/jquery.tipTip.minified.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/adminCommon.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/tooltip/tipTip.css');
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.cookie.js', CClientScript::POS_END);
?>
</div><!--/.fluid-container-->
<?php if (demo() && getGA()):?>
	<?php echo getGA(); ?>
<?php endif;?>
<?php if (demo() && getJivo()):?>
	<?php echo getJivo(); ?>
<?php endif;?>
</body>
</html>