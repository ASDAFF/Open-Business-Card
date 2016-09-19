<div>
	<?php if ($form->name): ?><p><?php echo tc('Имя');?>: <?php echo CHtml::encode($form->name); ?></p><?php endif; ?>

	<?php if ($form->email): ?><p><?php echo tc('Email');?>: <?php echo CHtml::encode($form->email); ?></p><?php endif; ?>	

	<?php if ($form->phone): ?><p><?php echo tc('Телефон');?>: <?php echo CHtml::encode($form->phone); ?></p><?php endif; ?>

	<?php if ($form->body): ?><p><?php echo tc('Сообщение');?>: <?php echo CHtml::encode($form->body); ?></p><?php endif; ?>
</div>