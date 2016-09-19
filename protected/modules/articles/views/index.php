<?php
$this->breadcrumbs=array(
	tc('Статьи'),
);
?>

<!-- articles list -->
<div id="posts-list" class="articles-list">
	<h2 class="page-heading"><span><?php echo tc('Статьи');?></span></h2>

	<?php
	if ($articles) :
		foreach ($articles as $article): ;?>
			<article class="format-standard">
				<h2  class="post-heading">
					<a href="<?php echo $article->getUrl();?>"><?php echo CHtml::encode($article->title); ?></a>
				</h2>
				<div class="excerpt">
					<?php if($article->short_page_body && utf8_strlen($article->short_page_body) > 5): ?>
						<?php echo CHtml::decode($article->short_page_body); ?>
					<?php else: ?>
						<?php echo CHtml::decode(truncateText($article->page_body, param('module_articles_truncateAfterWords', 50))); ?>
					<?php endif;?>
				</div>
				<a href="<?php echo $article->getUrl();?>" class="read-more"><?php echo tc('Читать дальше &#8594;');?></a>
			</article>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php if(!$articles) : ?>
		<div><?php echo tc('Список статей пуст');?></div>
	<?php endif; ?>

	<?php if($pages) : ?>
		<?php $this->widget('itemPaginator',array('pages' => $pages, 'header' => '')); ?>
		<div class="clearfix"></div>
	<?php endif;?>
</div>
<div class="clearfix"></div>
<!-- ENDS articles list -->