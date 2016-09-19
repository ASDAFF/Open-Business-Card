<div class="form">
	<?php $form=$this->beginWidget('CustomForm', array(
		'id'=>$this->modelName.'-form',
		'enableAjaxValidation'=>false,
		'htmlOptions' => array('enctype'=>'multipart/form-data'),
	)); ?>

	<p class="note"><?php echo tc('Поля, отмеченные <span class="required">*</span>, являются обязательными для заполнения.');?></p>

	<?php echo $form->errorSummary($model); ?>

	<?php
		$tabs = array(
			array('label'=>tc('Основное'), 'content' => $this->renderPartial('__tab_general', array('form' => $form, 'model' => $model), true), 'active' => true),
			array('label'=>tc('SEO'), 'content' => $this->renderPartial('__tab_seo', array('form' => $form, 'model' => $model), true), 'active' => false),
		);
	?>

	<?php
		$this->widget('bootstrap.widgets.TbTabs', array(
			'type'=>'tabs',
			'placement'=>'top',
			/*'htmlOptions' => array('class'=>'span8'),*/
			'id' => 'catalog-tabs',
			'tabs' => $tabs,
		));
	?>

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