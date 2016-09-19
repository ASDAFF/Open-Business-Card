<div class="form">

	<?php $form=$this->beginWidget('CustomForm', array(
		'id'=>'Gallery-form',
		'enableClientValidation'=>false,
	)); ?>

	<p class="note"><?php echo tc('Поля, отмеченные <span class="required">*</span>, являются обязательными для заполнения.');?></p>

	<?php echo $form->errorSummary($model); ?>

	<?php if(!$model->isNewRecord && $model->img): ?>
		<div class="rowold">
			<strong><?php echo CHtml::encode($model->getAttributeLabel('img')); ?>:</strong>
			<div>
				<?php echo Yii::app()->controller->returnImagePrettyPhoto($model, "gallery-grid", 0, param('maxWidthSmallThumb', 100), param('maxHeightSmallThumb', 70)) ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if (param('useGalleryGategory', 0)) : ?>
		<div class="rowold">
			<?php echo $form->labelEx($model,'id_category'); ?>
			<?php
			echo $form->dropDownList(
				$model,
				'id_category',
				GalleryCategory::getActiveCategories(),
				array(
					'class' => 'width250',
					'id' => 'id_category',
				)
			);
			?>
			<?php echo $form->error($model,'id_category'); ?>
		</div>
	<?php endif; ?>

	<div class="rowold">
		<?php
		$this->widget('application.modules.lang.components.langFieldWidget', array(
				'model' => $model,
				'field' => 'description',
				'type' => 'text'
			));
		?>
		<br/>
	</div>

	<div class="rowold buttons">
		<?php $this->widget('bootstrap.widgets.TbButton',
				array('buttonType'=>'submit',
					'type'=>'primary',
					'icon'=>'ok white',
					'label'=> tc('Сохранить'),
				)
		); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->

