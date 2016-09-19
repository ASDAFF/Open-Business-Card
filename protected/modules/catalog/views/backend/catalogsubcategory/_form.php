<div class="form">

	<?php $form=$this->beginWidget('CustomForm', array(
		'id'=>$this->modelName.'-form',
		'enableAjaxValidation'=>false,
	)); ?>

	<p class="note"><?php echo tc('Поля, отмеченные <span class="required">*</span>, являются обязательными для заполнения.');?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="rowold">
		<?php echo $form->labelEx($model,'id_category'); ?>
		<?php echo $form->dropDownList($model, 'id_category', CatalogCategory::getActiveCategories(), array('class' => 'width240')); ?>
		<?php echo $form->error($model,'id_category'); ?>
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

	<div class="rowold buttons">
		<?php $this->widget('bootstrap.widgets.TbButton',
				array('buttonType'=>'submit',
					'type'=>'primary',
					'icon'=>'ok white',
					'label'=> $model->isNewRecord ? tc('Добавить') : tc('Сохранить'),
				)
		); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->