<div class="form">
	<?php $form=$this->beginWidget('CustomForm', array(
		'id'=>$this->modelName.'-form',
		'enableAjaxValidation'=>false,
	)); ?>

	<p class="note"><?php echo tc('Поля, отмеченные <span class="required">*</span>, являются обязательными для заполнения.');?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="rowold">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name', array('class' => 'width200')); ?>
		<div class="clear"></div>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="rowold">
		<?php echo $form->labelEx($model,'body'); ?>
		<?php echo $form->textArea($model,'body', array('class' => 'width500 height100')); ?>
		<div class="clear"></div>
		<?php echo $form->error($model,'body'); ?>
	</div>

	<div class="clear"></div>
	<br>

	<div class="rowold buttons">
		<?php $this->widget('bootstrap.widgets.TbButton',
				array('buttonType'=>'submit',
					'type'=>'primary',
					'icon'=>'ok white',
					'label'=> $model->isNewRecord ? tc('Добавить') : tc('Сохранить'),
				));
		?>
	</div>

	<?php $this->endWidget(); ?>
</div><!-- form -->