
<?php if ($categories) : ?>
	<ul id="catalog_categories" class="catalog_categories">
		<?php foreach ($categories as $key => $item) :?>
			<li class="segment-<?php echo $key; ?>">
				<a href="<?php echo CatalogCategory::getCatIdUrl($item->id, $item->title); ?>"><?php echo $item->title; ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

<?php if ($catalog) : ?>
	<!-- thumbs -->
	<div class="portfolio-thumbs clearfix catalog-thumbs">
		<?php foreach ($catalog as $item) : ?>
			<div class="catalog-item">
				<figure>
					<a href="<?php echo $item->getUrl(); ?>">
						<?php
						$img = $item->getMainImage();
						if ($img && $img->img) : ?>
								<img alt="" src="<?php echo Yii::app()->getBaseUrl().'/'.Catalog::UPLOAD_DIR.'/'.Catalog::CATALOG_DIR.'/'.Catalog::MODIFIED_IMG_DIR.'/'.Catalog::getThumb($img, param('maxWidthMediumThumbCatalog', 276), param('maxHeightMediumThumbCatalog', 207)) ?>" />
						<?php else: ?>
								<img alt="" src="<?php echo Catalog::returnEmptyImgUrl(param('maxWidthMediumThumbCatalog', 436), param('maxHeightMediumThumbCatalog', 273));?>" />
						<?php endif; ?>
					</a>
				</figure>

				<p>
					<?php echo tc('Наименование');?>: <?php echo CHtml::encode($item->title); ?>
				</p>
				<p><?php echo tc('Категория');?>:
					<span class="catalog_category">
						<a href="<?php echo CatalogCategory::getCatIdUrl($item->catalogCategory->id, $item->catalogCategory->title) ;?>">
							<?php echo $item->catalogCategory->title; ?>
						</a>
					</span>
				</p>

				<?php if (param('useTwoLevelCatalog', 0)) : ?>
					<p><?php echo tc('Подкатегория');?>:
						<span class="catalog_category">
							<a href="<?php echo CatalogSubCategory::getSubCatIdUrl($item->catalogSubCategory->id, $item->catalogSubCategory->title) ;?>">
								<?php echo $item->catalogSubCategory->title; ?>
							</a>
						</span>
					</p>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
	<!-- ends thumbs-->
<?php endif;?>

<?php if($pages) : ?>
	<?php $this->widget('itemPaginator',array('pages' => $pages, 'header' => '')); ?>
	<div class="clearfix"></div>
<?php endif;?>
<div class="clearfix"></div>