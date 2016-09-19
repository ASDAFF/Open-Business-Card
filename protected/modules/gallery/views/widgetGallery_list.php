<?php if ($categories && param('useGalleryGategory', 0)) : ?>
	<ul id="catalog_categories" class="catalog_categories">
		<?php foreach ($categories as $key => $item) :?>
			<li class="segment-<?php echo $key; ?>">
				<a href="<?php echo GalleryCategory::getCatIdUrl($item->id, $item->title); ?>"><?php echo $item->title; ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

<?php if($gallery) : ?>
	<!-- thumbs -->
	<div class="portfolio-thumbs clearfix">
		<?php foreach ($gallery as $item) : ?>
			<figure>
				<figcaption>
					<strong><?php echo CHtml::encode($item->description); ?></strong>
					<a href="javascript:void(0);" class="opener"></a>
				</figcaption>


				<?php if ($item->img):?>
				<a href="<?php echo Yii::app()->request->baseUrl.'/'.Gallery::UPLOAD_DIR.'/'.Gallery::GALLERY_DIR.'/'.Gallery::ORIGINAL_IMG_DIR.'/'.$item->img; ?>" data-rel="prettyPhoto[gallery]" class="thumb lightbox">
					<?php else: ?>
					<a href="<?php echo Gallery::returnEmptyImgUrl(param('maxWidthBigThumb', 800), param('maxHeightBigThumb', 600));?>" data-rel="prettyPhoto[gallery]" class="thumb lightbox">
						<?php endif; ?>

						<?php
						if ($item->img):
							echo CHtml::image(Yii::app()->getBaseUrl().'/'.Gallery::UPLOAD_DIR.'/'.Gallery::GALLERY_DIR.'/'.Gallery::MODIFIED_IMG_DIR.'/'.$item->getThumb(param('maxWidthMediumThumb', 400), param('maxHeightMediumThumb', 300)));
						else:
							echo CHtml::image(Gallery::returnEmptyImgUrl(param('maxWidthMediumThumb', 436), param('maxHeightMediumThumb', 273)));
						endif;
						?>
					</a>
			</figure>
		<?php endforeach; ?>
	</div>
	<!-- ends thumbs-->
<?php endif; ?>

<?php if($pages) : ?>
	<?php $this->widget('itemPaginator',array('pages' => $pages, 'header' => '')); ?>
	<div class="clearfix"></div>
<?php endif;?>
<div class="clearfix"></div>