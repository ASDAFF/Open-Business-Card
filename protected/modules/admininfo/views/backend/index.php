<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Данные администратора');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Данные администратора'),
);

$this->adminTitle = tc('Данные администратора');
?>

<div class="form">
<?php
	$model->scenario = 'changeAdminInfo';
	$model->password = '';
	$model->password_repeat = '';

	$form=$this->beginWidget('CustomForm', array(
		'enableAjaxValidation'=>false,
	));
	?>
	<div class="rowold">&nbsp;</div>

	<p class="note"><?php echo tc('Поля, отмеченные <span class="required">*</span>, являются обязательными для заполнения.');?></p>

    <?php //echo $form->errorSummary($model); ?>

    <div class="rowold">
        <?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password',array('size'=>20,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>

    <div class="rowold">
        <?php echo $form->labelEx($model,'password_repeat'); ?>
        <?php echo $form->passwordField($model,'password_repeat',array('size'=>20,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'password_repeat'); ?>
    </div>

	<div class="rowold">
        <?php echo $form->labelEx($model,'email'); ?>
        <?php echo $form->textField($model,'email',array('size'=>20,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>

	<div class="rowold">
        <?php echo $form->labelEx($model,'old_password'); ?>
        <?php echo $form->passwordField($model,'old_password',array('size'=>20,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'old_password'); ?>
    </div>

    <div class="rowold buttons">
		<?php $this->widget('bootstrap.widgets.TbButton',
				array('buttonType'=>'submit',
					'type'=>'primary',
					'icon'=>'ok white',
					'label'=> tc('Изменить'),
				)
		); ?>
	</div>

	<?php $this->endWidget(); ?>

</div>