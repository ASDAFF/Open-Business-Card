<!doctype html>
<html class="no-js" lang="<?php echo Yii::app()->language;?>">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<meta name="keywords" content="<?php echo CHtml::encode($this->pageKeywords); ?>" />
	<meta name="description" content="<?php echo CHtml::encode($this->pageDescription); ?>" />

	<link href='http://fonts.googleapis.com/css?family=Ubuntu:700,400&amp;subset=latin,cyrillic' rel='stylesheet'>

	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<?php
	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/reset.css');
	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/comments.css');
	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/form.css');
	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/style.css');

	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/superfish.css');
	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prettyPhoto.css');
	//Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/poshytip/src/tip-twitter/tip-twitter.css');
	//Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/poshytip/src/tip-yellowsimple/tip-yellowsimple.css');
	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/flexslider.css');
	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/lessframework.css');
	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/skin.css');

	Yii::app()->clientScript->registerCoreScript('jquery');
	//Yii::app()->clientScript->registerCoreScript('jquery.ui');
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/browser_fix.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/superfish/js/hoverIntent.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/superfish/js/superfish.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/superfish/js/supersubs.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.prettyPhoto.js', CClientScript::POS_HEAD);
	//Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/poshytip/src/jquery.poshytip.min.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.flexslider.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/modernizr.js', CClientScript::POS_HEAD);

	//Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/css3-mediaqueries.js', CClientScript::POS_HEAD);
	//Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/tabs.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/custom.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.cookie.js', CClientScript::POS_END);
	
	if (param('useShowInfoUseCookie')) {
		Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/cookiebar/jquery.cookiebar.js', CClientScript::POS_END);
		Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/js/cookiebar/jquery.cookiebar.css');
	}
	?>

	<link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico" type="image/x-icon" />
</head>

<?php $adminView = (Yii::app()->user->getState("isAdmin")) ? true : false; ?>
<?php $multiLangs = false; ?>

<body>
<?php if (demo()) :?>
	<?php $this->renderPartial('//site/ads-block', array()); ?>
<?php endif; ?>
<header id="header-top" class="clearfix">
	<div class="wrapper clearfix">
		<a href="<?php echo Yii::app()->controller->createAbsoluteUrl('/'); ?>" id="logo"><img  src="<?php echo Yii::app()->getBaseUrl(true);?>/img/design/logo-open-bc.png" alt="<?php echo Yii::app()->name;?>"></a>

		<?php $languages = Lang::getActiveLangs(true); ?>
		<?php if(count($languages) > 1):?>
			<?php $multiLangs = true;?>
			<?php $this->widget('application.modules.lang.components.langSelectorWidget', array( 'type' => 'links', 'languages' => $languages )); ?>
			<div class="clear"></div>
		<?php endif;?>
		
		<?php if (param('useSiteSearch', 0)) : ?>
			<div class="search<?php echo ($multiLangs) ? ' with-multi-langs' : '';?>">
				<input type="text" onblur="if (this.value == '') {this.value = '<?php echo tc('Поиск');?>';}" onfocus="this.value = '';" value="<?php echo tc('Поиск');?>" class="textbox" name="s" id="search_text">
				<input type="submit" name="submit" id="submit" value="<?php echo tc('Поиск');?>" onclick="prepareSearch(); return false;">
			</div>
		<?php endif; ?>

		<nav>
			<?php
			$this->widget('application.components.MainMenu',array(
				'id' => 'nav',
				'items'=>$this->topMenu,
				'htmlOptions' => array('class' => 'sf-menu'),
				'encodeLabel' => false,
				'activateParents' => true,
			)); ?>
			<div id="combo-holder"></div>
		</nav>
	</div>
	<noscript><div class="noscript"><?php echo tc('Включите поддержку JavaScript в Вашем браузере для комфортной работы с сайтом.');?></div></noscript>
</header>


<?php echo $content; ?>

<footer id="footer">
	<div class="wrapper">

		<ul  class="widget-cols clearfix">
			<li class="first-col">

				<div class="widget-block">
					<?php
					$aboutUs = Info::getInfo(Info::TYPE_ABOUT);
					if($aboutUs): ?>
						<h4><?php echo tc('О нас');?></h4>
						<?php echo $aboutUs; ?>
					<?php endif; ?>
				</div>
			</li>

			<li class="second-col">

				<div class="widget-block">
					<h4><?php echo tc('Категории');?></h4>
					<ul class="menu-categories page-text">
						<?php foreach ($this->bottomCatalogCategories as $key => $item) :?>
							<li><a href="<?php echo CatalogCategory::getCatIdUrl($item['id'], $item['title']); ?>"><?php echo CHtml::encode($item['title'].' ('.$item['count'].')'); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>

			</li>

			<li class="third-col">

				<div class="widget-block">
					<div  class="footer-col tweet">
						<h4><?php echo tc('Контакты');?></h4>
						<ul class="list-contact page-text">
							<?php if(param('adminPhone')):?>
								<li class="phone"><?php echo param('adminPhone'); ?></li>
							<?php endif; ?>
							<?php if(param('adminEmail')):?>
								<li class="email"><?php echo $this->protectEmail(param('adminEmail')); ?></li>
							<?php endif; ?>
							<?php if(param('adminAddress')):?>
								<li class="address"><?php echo param('adminAddress'); ?></li>
							<?php endif; ?>
						</ul>
					</div>
				</div>

			</li>
		</ul>

		<div class="footer-bottom">
			<div class="left">
				<p class="copyrights">
					<span class="slogan">&copy;&nbsp;<?php echo Yii::app()->name;?>,&nbsp;<?php echo date('Y'); ?></span>
				</p>
			</div>
			<div class="right">
				<a href="#header-top" class="up">
					<span class="arrow"></span>
					<span class="text"><?php echo tc('Наверх');?></span>
				</a>
			</div>
		</div>
	</div>
</footer>

<div id="loading" style="display:none;"><?php echo tc('Загрузка содержимого ...');?></div>
<?php
	Yii::app()->clientScript->registerScript('loading', '
		$("#loading").bind("ajaxSend", function(){
			$(this).show();
		}).bind("ajaxComplete", function(){
			$(this).hide();
		});
	', CClientScript::POS_READY);

	if (param('useSiteSearch', 0)) {
		Yii::app()->clientScript->registerScript('search-init', '
			$(document).ready(function() {
				$(".search input#search_text").keypress(function(e) {
					var code = (e.keyCode ? e.keyCode : e.which);
					if(code == 13) { // Enter keycode
						prepareSearch();
						return false;
					}
				});
			});

			function prepareSearch() {
				var term = $(".search input#search_text").val();

				if (term.length > '.Yii::app()->controller->minLengthSearch.' && term != "'.tc('Поиск').'") {
					window.location.replace("'.Yii::app()->createAbsoluteUrl('/site/search').'?term="+term+"");
				}
				else {
					alert("'.tc('Минимум').' '.(Yii::app()->controller->minLengthSearch + 1).' '.tc('символа').'");
				}
			}
		', CClientScript::POS_END);
	}
?>

<?php if($adminView):
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/tooltip/jquery.tipTip.minified.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/tooltip/tipTip.css');
	Yii::app()->clientScript->registerScript('adminMenuToolTip', '
		$(function(){
			$(".adminMainNavItem").tipTip({maxWidth: "auto", edgeOffset: 10, delay: 200});
		});
	', CClientScript::POS_READY);?>

	<div class="admin-menu-small" onclick="location.href='<?php echo Yii::app()->controller->createUrl('/admin/backend/main/index'); ?>'" style="cursor: pointer;">
		<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/adminmenu/administrator.png" alt="<?php echo tc('Администрирование');?>" title="<?php echo tc('Администрирование');?>" class="adminMainNavItem" />
	</div>
<?php endif; ?>

<?php if (demo() && getGA()):?>
	<?php echo getGA(); ?>
<?php endif;?>
<?php if (demo() && getJivo()):?>
	<?php echo getJivo(); ?>
<?php endif;?>

<?php
$this->widget('application.modules.fancybox.EFancyBox', array(
		'target'=>'a.fancy',
		'config'=>array(
			'ajax' => array('data'=>"isFancy=true"),
			'titlePosition' => 'inside'
		),
	)
);
?>

<?php		
	if (param('useShowInfoUseCookie') && isset(Yii::app()->controller->privatePolicyPage) && !empty(Yii::app()->controller->privatePolicyPage)) {
		$privatePolicyPage = Yii::app()->controller->privatePolicyPage;
		Yii::app()->clientScript->registerScript('display-info-use-cookie-policy', '
			$.cookieBar({/*acceptOnContinue:false, */ fixed: true, bottom: true, message: "'.  CHtml::encode(Yii::app()->name).' '.CHtml::encode(tc('uses cookie')).', <a href=\"'.$privatePolicyPage->getUrl().'\" target=\'_blank\'>'.$privatePolicyPage->getStrByLang('title').'</a>", acceptText : "X"});
		', CClientScript::POS_READY);
	}
?>

</body>
</html>