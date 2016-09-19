<div class="form">

<?php $form=$this->beginWidget('CustomForm', array(
	'id'=>$this->modelName.'-form',
	'enableClientValidation'=>false,
)); ?>

	<p class="note"><?php echo tc('Поля, отмеченные <span class="required">*</span>, являются обязательными для заполнения.');?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'cat_id'); ?>
		<?php echo $form->dropDownList($model, 'cat_id', PriceCategory::getPriceCategory(), array('class' => 'width250')); ?>
		<?php echo $form->error($model,'cat_id'); ?>
	</div>
	
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
	
	<div class="rowold">
		<?php
		$this->widget('application.modules.lang.components.langFieldWidget', array(
				'model' => $model,
				'field' => 'cost',
				'type' => 'string',
			));
		?>
		<br/>
	</div>

	<div class="rowold">
		<?php echo $form->checkboxRow($model, 'is_bold'); ?>
	</div>

	<div class="clear"></div>

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