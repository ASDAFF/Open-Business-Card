<div>
	<?php if ($form->name): ?><p><?php echo tc('Имя');?>: <?php echo CHtml::encode($form->name); ?></p><?php endif; ?>

	<?php if ($form->body): ?><p><?php echo tc('Отзыв');?>: <?php echo CHtml::encode($form->body); ?></p><?php endif; ?>
</div>