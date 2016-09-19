<?php
$this->breadcrumbs=array(
	tc('Отзывы'),
);
?>

<h2 class="page-heading"><span><?php echo tc('Отзывы');?></span></h2>

<div class="add-review-link">
	<?php	echo CHtml::link(tc('Добавить отзыв'), Yii::app()->createUrl('/reviews/main/add'));?>
</div>

<?php
if ($reviews) : ?>
	<div id="comments-wrap">
		<ol class="commentlist">
			<?php foreach ($reviews as $review) :?>
				<li class="comment thread-even depth-1" id="li-comment-3">
					<div id="comment-<?php echo $review->id;?>" class="comment-body clearfix">
						<img alt='' src='http://0.gravatar.com/avatar/4f64c9f81bb0d4ee969aaf7b4a5a6f40?s=35&amp;d=&amp;r=G' class='avatar avatar-35 photo' height='35' width='35' />
						<div class="comment-author vcard"><?php echo CHtml::encode($review->name); ?></div>
						<div class="comment-meta commentmetadata">
							<span class="comment-date"><?php echo $review->dateCreatedFormat; ?></span>
						</div>
						<div class="comment-inner">
							<p><?php echo CHtml::encode($review->body); ?></p>
						</div>
					</div>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
<?php endif; ?>

<?php if(!$reviews) : ?>
	<div><?php echo tc('Список отзывов пуст');?></div>
<?php endif; ?>

<?php if($pages) : ?>
	<?php $this->widget('itemPaginator',array('pages' => $pages, 'header' => '')); ?>
	<div class="clearfix"></div>
<?php endif;?>
<div class="clearfix"></div>