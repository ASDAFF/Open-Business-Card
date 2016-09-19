<div class="form">

	<?php
		Yii::app()->user->setFlash('help', Yii::t('common', 'Вы можете загрузить свои иконки флагов в директорию flag_dir, и они будут доступны для выбора', array('flag_dir' => Lang::FLAG_DIR)));

		Lang::publishAssetsDD();

		$form=$this->beginWidget('CustomForm', array(
		'id'=>$this->modelName.'-form',
		'enableAjaxValidation'=>false,
		'htmlOptions' => array('class' => 'form-disable-button-after-submit'),
	)); ?>

	<p class="note"><?php echo tc('Поля, отмеченные <span class="required">*</span>, являются обязательными для заполнения.');?></p>

	<?php echo $form->errorSummary($model); ?>

    <div class="rowold">
		<?php echo $form->labelEx($model,'flag_img'); ?>
		<?php
		$flags = Lang::getFlagImgArray();
		echo '<select name="Lang[flag_img]" id="flag_img">';
		foreach($flags as $flag=>$name){
			$selected = $model->flag_img == $flag ? 'selected="selected"' : '';
			echo '<option '.$selected.' value="'.$flag.'" title="'.Yii::app()->baseUrl.Lang::FLAG_DIR.$flag.'">'.($name ? $name : $flag).'</option>';
		}
		echo '</select>';
		?>
		<?php echo $form->error($model,'flag_img'); ?>
    </div>

	<br/>

	<?php if($model->isNewRecord) { ?>

	<div class="rowold">
		<?php echo $form->labelEx($model,'name_iso'); ?>
		<?php echo $form->dropDownList($model,'name_iso', Lang::getISOlangForAdd()); ?>
		<?php echo $form->error($model,'name_iso'); ?>
	</div>

    <br/>

	<div class="rowold">
		<?php echo $form->labelEx($model,'copy_lang_from'); ?>
		<?php echo $form->dropDownList($model,'copy_lang_from', Lang::getActiveLangsTranslated(), array('class' => 'width150')); ?>
		<?php echo $form->error($model,'copy_lang_from'); ?>
	</div>

	<?php } else { ?>
	<div class="rowold">
		<b><?php echo tc('Код языка ISO 639-1'); ?></b>: <?php echo $model->name_iso. ( (Lang::getISOname($model->name_iso)) ? ' ('.Lang::getISOname($model->name_iso).')' : ''); ?>
	</div>
	<?php } ?>

	<?php
	$this->widget('application.modules.lang.components.langFieldWidget', array(
			'model' => $model,
			'field' => 'name',
			'type' => 'string'
		));
	?>

	<div class="clear"></div>

	<div class="rowold buttons">
		   <?php $this->widget('bootstrap.widgets.TbButton',
				array('buttonType'=>'submit',
					'type'=>'primary',
					'icon'=>'ok white',
					'label'=> $model->isNewRecord ? tc('Добавить') : tc('Сохранить'),
					'htmlOptions' => array(
						'class' => 'submit-button',
					),
				)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
    $(document).ready(function(e) {
        try {
            $("#flag_img").msDropDown();
        } catch(e) {
            alert(e.message);
        }
    });
</script>
