<article class="format-standard">
	<h2  class="post-heading">
		<a href="<?php echo $data['url'] ;?>">
			<?php echo CHtml::decode(truncateText($data['title'], 7)); ?>
		</a>
	</h2>
	<div class="excerpt">
		<?php
		/*$body = $data['body'];
		if (utf8_strlen($body) > 300)
			$body = utf8_substr($body, 0, 300).' ...';
		echo $body;*/
		//echo highlightKeywords($body, $words);
		echo $data['body'];
		?>
	</div>
	<a href="<?php echo $data['url'] ;?>" class="read-more"><?php echo tc('Подробнее &#8594');?>;</a>
</article>