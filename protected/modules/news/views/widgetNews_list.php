<?php if ($news) : ?>
	<div id="posts-list">
		<?php foreach ($news as $item): ;?>
			<article class="format-standard">
				<div class="entry-date">
					<div class="number">
						<?php echo (array_key_exists('first', $item->dateCreated)) ? $item->dateCreated['first'] : "";?>
					</div>
					<div class="year">
						<?php echo (array_key_exists('second', $item->dateCreated)) ? $item->dateCreated['second'] : "";?>
					</div>
				</div>
				<h2  class="post-heading">
					<a href="<?php echo $item->getUrl();?>"><?php echo CHtml::encode($item->title); ?></a>
				</h2>
				<div class="excerpt">
					<?php if($item->short_body && utf8_strlen($item->short_body) > 5): ?>
						<?php echo CHtml::decode($item->short_body); ?>
					<?php else: ?>
						<?php echo truncateText($item->body, param('newsModule_truncateAfterWords', 50)); ?>
					<?php endif;?>
				</div>
				<a href="<?php echo $item->getUrl();?>" class="read-more"><?php echo tc('Читать дальше &#8594;');?></a>
			</article>
		<?php endforeach; ?>
	</div>
	<div class="clearfix"></div>
<?php endif; ?>

<?php if($pages) : ?>
	<?php $this->widget('itemPaginator',array('pages' => $pages, 'header' => '')); ?>
	<div class="clearfix"></div>
<?php endif;?>
<div class="clearfix"></div>