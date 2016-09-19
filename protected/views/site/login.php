<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Вход');
$this->breadcrumbs=array(
	tc('Вход'),
);
?>

<h2 class="page-heading"><span><?php echo tc('Вход');?></span></h2>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'authForm',
	'enableClientValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
)); ?>

	<p class="note"><?php echo tc('Поля, отмеченные <span class="required">*</span>, являются обязательными для заполнения.');?></p>

	<?php if(demo()):?>
		<?php
			$model->username = 'admin@monoray.ru';
			$model->password = 'admin';
		?>
	<?php endif;?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?> <br />
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?> <br />
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	
	<?php if ($model->scenario == 'withCaptcha' && CCaptcha::checkRequirements()): ?>
		<div class="row">
			<?php echo $form->labelEx($model, 'verifyCode');?>
			<?php echo $form->textField($model, 'verifyCode',array('autocomplete' => 'off'));?><br/>
			<?php $this->widget('CCaptcha',
				array(
					'captchaAction' => '/site/captcha',
					'buttonOptions' => array('class' => 'get-new-ver-code'),
					'clickableImage' => true,
					'imageOptions'=>array('id'=>'login_captcha')
				)
			); ?>
			<?php echo $form->error($model, 'verifyCode');?>
			<br />
		</div>
	<?php endif; ?>

	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(tc('Вход')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
