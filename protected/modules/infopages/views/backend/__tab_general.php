<div class="rowold">
	<?php echo $form->labelEx($model,'active'); ?>
	<?php echo $form->dropDownList($model, 'active', array(
		InfoPages::STATUS_ACTIVE => tc('Активно'),
		InfoPages::STATUS_INACTIVE => tc('Неактивно'),
	), array('class' => 'width150')); ?>
	<?php echo $form->error($model,'active'); ?>
</div>

<div class="rowold">
	<?php
	$this->widget('application.modules.lang.components.langFieldWidget', array(
			'model' => $model,
			'field' => 'title',
			'type' => 'string',
		));
	?>
	<br/>
</div>

<div class="rowold">
	<?php
    $this->widget('application.modules.lang.components.langFieldWidget', array(
    		'model' => $model,
    		'field' => 'body',
            'type' => 'text-editor'
    	));
    ?>
	<br/>
</div>

<div class="rowold">
	<?php echo $form->labelEx($model,'widget'); ?>
	<?php echo $form->dropDownList($model,'widget', InfoPages::getWidgetOptions()); ?>
	<?php echo $form->error($model,'widget'); ?>
</div>