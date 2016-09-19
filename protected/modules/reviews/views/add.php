<?php
$this->breadcrumbs=array(
	tc('Отзывы') => array('/reviews/main/index'),
	tc('Добавить отзыв'),
);
?>

<h2 class="page-heading"><span><?php echo tc('Добавить отзыв');?></span></h2>

<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'action' => Yii::app()->controller->createUrl('/reviews/main/add'),
		'id'=>'commentform',
		'enableAjaxValidation'=>false,
		//'htmlOptions' => array('class' => 'bestform'),
		'clientOptions'=>array('validateOnSubmit'=>false),
	)); ?>

	<p class="note"><?php echo tc('Поля, отмеченные <span class="required">*</span>, являются обязательными для заполнения.');?></p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
			<?php echo $form->labelEx($model,'name'); ?><br />
			<?php echo $form->textField($model,'name', array('class' => 'width200')); ?>

			<?php //echo $form->error($model,'name'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'body'); ?><br />
			<?php echo $form->textArea($model,'body', array('class' => 'width500 height100')); ?>

			<div class="clearfix"></div>
			<?php //echo $form->error($model,'body'); ?>
		</div>
		<div class="clearfix"></div>

		<div class="row">
			<?php echo $form->labelEx($model, 'verifyCode');?> <br />
			<?php
				$this->widget('CCaptcha',
				array(
					'captchaAction' => '/reviews/main/captcha',
					'buttonOptions' => array('style' => 'display:block;')
				)
			);?>

			<?php echo $form->textField($model, 'verifyCode');?><br/>
			<?php // echo $form->error($model, 'verifyCode');?>
		</div>

		<div class="field">
			<label class="width">&nbsp;</label>
			<?php echo CHtml::submitButton(tc('Добавить'));?>
		</div>
	<?php $this->endWidget(); ?>
</div>