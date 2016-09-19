<?php

if (param('useTwoLevelCatalog', 0)) {
	$this->breadcrumbs=array(
		tc('Каталог')=>array('index'),
		$model->catalogCategory->title => CatalogCategory::getCatIdUrl($model->catalogCategory->id, $model->catalogCategory->title),
		$model->catalogSubCategory->title => CatalogSubCategory::getSubCatIdUrl($model->catalogSubCategory->id, $model->catalogSubCategory->title),
		$model->title,
	);
}
else {
	$this->breadcrumbs=array(
		tc('Каталог')=>array('index'),
		$model->catalogCategory->title => CatalogCategory::getCatIdUrl($model->catalogCategory->id, $model->catalogCategory->title),
		$model->title,
	);
}
?>

<?php
Yii::app()->clientScript->registerScript('flexslider', '
	$(".flexslider").flexslider({
        animation: "fade",
        controlNav: false,
        directionNav: true,
        keyboardNav: false
    });
', CClientScript::POS_READY);
?>

<h1 class="page_title"><?php echo $model->title; ?></h1>
<div class="columns catalog-view">
	<div class="column column34">
		<!--<div>
			Категория:
			<a href="<?php echo CatalogCategory::getCatIdUrl($model->catalogCategory->id, $model->catalogCategory->title) ;?>">
				<?php echo $model->catalogCategory->title; ?>
			</a>

			<?php if (param('useTwoLevelCatalog', 0)) :  ?>
				<br />
				Подкатегория:
				<a href="<?php echo CatalogSubCategory::getSubCatIdUrl($model->catalogSubCategory->id, $model->catalogSubCategory->title) ;?>">
					<?php echo $model->catalogSubCategory->title; ?>
				</a>
			<?php endif;?>
		</div>-->

		<p><?php echo $model->description; ?></p>
		<p class="item-price"><?php echo $model->cost; ?></p>
	</div>
	<div class="column column67">
		<div id="content_slide">
			<?php
				$images = $model->getAllImages();
				if ($images) : ?>
				<div class="flexslider">
					<ul class="slides">
						<?php foreach($images as $image) :?>
							<?php if ($image && $image->img) : ?>
								<li>
									<img alt="" title="" src="<?php echo Yii::app()->getBaseUrl().'/'.Catalog::UPLOAD_DIR.'/'.Catalog::CATALOG_DIR.'/'.Catalog::MODIFIED_IMG_DIR.'/'.Catalog::getThumb($image, param('maxWidthBigThumbCatalog', 500), param('maxHeightBigThumbCatalog', 375)) ?>" />
								</li>
							<?php else: ?>
								<li>
									<img alt="" title="" src="<?php echo Catalog::returnEmptyImgUrl(param('maxWidthBigThumbCatalog', 500), param('maxHeightBigThumbCatalog', 375));?>" />
								</li>
							<?php endif;?>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php else: ?>
				<img src="<?php echo Yii::app()->request->baseUrl.'/img/default/no_image_500_400.png'; ?>" alt="" title="" />
			<?php endif; ?>
		</div>
	</div>
</div>