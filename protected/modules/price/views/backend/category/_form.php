<div class="form">

<?php $form=$this->beginWidget('CustomForm', array(
	'id'=>$this->modelName.'-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">
		<?php echo tc('Поля, отмеченные <span class="required">*</span>, являются обязательными для заполнения.');?>
	</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="rowold">
		<?php
		$this->widget('application.modules.lang.components.langFieldWidget', array(
				'model' => $model,
				'field' => 'name',
				'type' => 'string',
			));
		?>
		<br/>
	</div>

	<div class="rowold buttons">
		<?php $this->widget('bootstrap.widgets.TbButton',
		array('buttonType' => 'submit',
			'type' => 'primary',
			'icon' => 'ok white',
			'label' => $model->isNewRecord ? tc('Добавить') : tc('Сохранить'),
		));
		?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->