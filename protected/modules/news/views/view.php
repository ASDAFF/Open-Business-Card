<?php
$this->breadcrumbs=array(
	tc('Новости') => array('/news/main/index'),
	$model->title
);
?>

<!-- posts list -->
<div id="posts-list" class="single-post">
	<h2 class="page-heading"><span><?php echo tc('Новости');?></span></h2>

	<article class="format-standard">
		<div class="entry-date">
			<div class="number">
				<?php echo (array_key_exists('first', $model->dateCreated)) ? $model->dateCreated['first'] : "";?>
			</div>
			<div class="year">
				<?php echo (array_key_exists('second', $model->dateCreated)) ? $model->dateCreated['second'] : "";?>
			</div>
		</div>
		<h2  class="post-heading">
			<?php echo CHtml::encode($model->title); ?>
		</h2>
		<div class="post-content">
			<?php echo CHtml::decode($model->body); ?>
		</div>
	</article>
</div>
<!-- ENDS posts list -->