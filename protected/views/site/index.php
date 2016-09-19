<?php
if($model){
	if (isset($model->page)) {
		if($model->page->seo_title){
			$this->pageTitle = $model->page->seo_title;
		} else {
			$this->pageTitle = Yii::app()->name;
		}
	}
}
?>

<!-- slider holder -->
<div id="slider-holder" class="clearfix">
	<!-- slider -->
	<div class="flexslider home-slider">
		<ul class="slides">
			<li>
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/slider/1.jpg" alt="1" />
				<p class="flex-caption">Tesla S</p>
			</li>
			<li>
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/slider/2.jpg" alt="2" />
				<p class="flex-caption">Volvo</p>
			</li>
			<li>
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/slider/3.jpg" alt="3" />
				<p class="flex-caption">Tesla S</p>
			</li>
		</ul>
	</div>
	<!-- ENDS slider -->

	<div class="home-slider-clearfix "></div>

	<!-- Headline -->
	<div id="headline">
		<?php $slogan = Info::getInfo(Info::TYPE_SLOGAN); ?>
		<?php echo $slogan;?>
	</div>
	<!-- ENDS headline -->
</div>
<!-- ENDS slider holder -->

<!-- home-block -->
<div class="home-block" >
	<?php
	foreach(Yii::app()->user->getFlashes() as $key => $message) {
		if ($key=='error' || $key == 'success' || $key == 'notice'){
			echo "<div class='flash-{$key}'>{$message}</div>";
		}
	}
	?>

	<?php
	$stock = Info::getInfo(Info::TYPE_STOCK);
	if($stock): ?>
		<!-- акция !-->
		<div class="introduction">
			<?php echo $stock; ?>
		</div>
	<?php endif; ?>

	<?php
	if($model){
		if (isset($model->page)) {
			if($model->page->body){
				echo $model->page->body;
			}

			if ($model->page->widget){
				echo '<div class="clearfix"></div><div class="page-widget">';
				Yii::import('application.modules.'.$model->page->widget.'.components.*');
				if($model->page->widget == 'contactform'){
					$this->widget('ContactformWidget', array('page' => 'index'));
				} else {
					$this->widget(ucfirst($model->page->widget).'Widget');
				}
				echo '</div>';
				echo '<div class="clearfix"></div>';
			}
		}
	}
	?>

	<?php
	$randomItems = Catalog::getRandomItems();
	if($randomItems && count($randomItems) > 0):?>
		<h2 class="home-block-heading"><span><?php echo tc('Случайные');?></span></h2>
		<div class="one-third-thumbs clearfix" >
			<?php $i = 1;?>
			<?php foreach($randomItems as $item): ?>
				<?php $addClass = '';?>
				<?php
				$newLine = ($i % 3) ? $addClass="" : $addClass="last";
				?>
				<figure class="<?php echo $addClass;?>">
					<figcaption>
						<strong><?php echo $item['title']; ?></strong>
						<em><?php echo $item['cost']; ?></em>
						<a href="<?php echo Catalog::getItemUrl($item['id'], $item['title']); ?>" class="opener"></a>
					</figcaption>

					<a href="<?php echo Catalog::getItemUrl($item['id'], $item['title']); ?>" class="thumb">
						<?php if (isset($item['img']) && $item['img']) : ?>
							<img alt="" src="<?php echo Yii::app()->getBaseUrl().'/'.Catalog::UPLOAD_DIR.'/'.Catalog::CATALOG_DIR.'/'.Catalog::MODIFIED_IMG_DIR.'/'.Catalog::getThumb($item['img'], param('maxWidthMediumThumbCatalog', 436), param('maxHeightMediumThumbCatalog', 273)) ?>" />
						<?php else: ?>
							<img alt="" src="<?php echo Catalog::returnEmptyImgUrl(param('maxWidthMediumThumbCatalog', 436), param('maxHeightMediumThumbCatalog', 273));?>" />
						<?php endif; ?>
					</a>
				</figure>
				<?php $i++;?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

</div>
<!-- ENDS home-block -->