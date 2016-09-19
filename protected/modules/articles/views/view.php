<?php
$this->breadcrumbs=array(
	tc('Статьи')=>array('index'),
	$model->title,
);
?>

<!-- posts list -->
<div id="posts-list" class="articles-list single-post">
	<h2 class="page-heading"><span><?php echo tc('Статьи');?></span></h2>

	<article class="format-standard">
		<h2  class="post-heading">
			<?php echo CHtml::encode($model->title); ?>
		</h2>
		<div class="post-content">
			<?php echo CHtml::decode($model->page_body); ?>
		</div>
	</article>
</div>
<!-- ENDS posts list -->