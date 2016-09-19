<?php
$this->breadcrumbs=array(
	tc('Новости'),
);
?>

<!-- posts list -->
<div id="posts-list">
	<h2 class="page-heading"><span><?php echo tc('Новости');?></span></h2>

	<?php
	if ($items) :
		foreach ($items as $item): ;?>
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
	<?php endif; ?>

	<?php if(!$items) : ?>
		<div><?php echo tc('Список новостей пуст');?></div>
	<?php endif; ?>

	<?php if($pages) : ?>
		<?php $this->widget('itemPaginator',array('pages' => $pages, 'header' => '')); ?>
		<div class="clearfix"></div>
	<?php endif;?>
</div>
<div class="clearfix"></div>
<!-- ENDS posts list -->