<div class="form well form-vertical">
	<div class="row-fluid">
		<div id="result"></div>
	</div>
	
	<div class="row-fluid">
		<div class="span8">
			<div class="span4">
				<?php $this->widget('bootstrap.widgets.TbButton',
					array('buttonType'=>'link',
						//'type'=>'warning',
						'type'=>'info',
						'icon'=>'repeat white',
						'label'=> tc('Очистить папку assets'),
						'htmlOptions' => array('class' => 'confirm-reset', 'value' => 'assets')
					));
			?>
			</div>
			<div class="span4">
				<?php $this->widget('bootstrap.widgets.TbButton',
					array('buttonType'=>'link',
						'type'=>'inverse',
						//'icon'=>'off white',
						'icon'=>'repeat white',
						'label'=> tc('Очистить папку runtime'),
						'htmlOptions' => array('class' => 'confirm-reset', 'value' => 'runtime')

					));
				?>
			</div>
		</div>
	</div>
</div>

<div class="clear"></div>

<div class="form">
<?php $form=$this->beginWidget('CustomForm', array(
	'id'=>'News-form',
	'enableClientValidation'=>false,
)); ?>

	<p class="note"><?php echo tc('Поля, отмеченные <span class="required">*</span>, являются обязательными для заполнения.');?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="rowold padding-bottom10">
		<div class="rowold">
			<?php echo $form->checkboxRow($model,'is_offline'); ?>
			<?php echo $form->error($model,'is_offline'); ?>
		</div>
	</div>

	<div class="rowold">
		<?php echo $form->labelEx($model,'allow_ip'); ?>
		<?php echo '<div class="padding-bottom10"><sub>'.tc('Через запятую').'</sub></div>';?>
		<?php echo $form->textField($model,'allow_ip', array('size' => 100)); ?>
		<?php echo $form->error($model,'allow_ip'); ?>
	</div>

    <div class="rowold">
		<?php echo $form->labelEx($model,'page'); ?>
		<?php
			$this->widget('application.components.fieldEditor', array(
				'model' => $model,
				'field' => 'page',
				'type' => 'text-editor'
			));
		?>
		<?php echo $form->error($model,'page'); ?>
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

<?php
Yii::app()->clientScript->registerScript('confirm-clear-cache-maintenance', '
	$("a.confirm-reset").on("click", function () {
		if ($(this).attr("disabled") == "disabled" || !confirm("'.tc('Вы действительно хотите очистить выбранный кэш?').'")) {
			return false;
		}

		$(this).attr("disabled", "disabled");

		$.ajax({
			url: "'.Yii::app()->createUrl('/service/backend/main/doclear').'",
			data: {target:$(this).attr("value")},
			success: function(result){
				$("#result").html(result);
				$("a.confirm-reset").removeAttr("disabled");
			}
		});
	});
', CClientScript::POS_READY);