<div>
	<img src="https://maps.googleapis.com/maps/api/staticmap?center=56.634105,47.945054&zoom=17&size=900x400&markers=color:blue|label:%22%22|56.634105,47.945054&language=<?php echo Yii::app()->language;?>" />
</div><br /><div class="clearfix"></div>

<?php
	if(!Yii::app()->user->isGuest){
		$model->email = Yii::app()->user->email;
	}

	if(param('adminEmail')){
		echo '<p>'.tc('Email').': '.Yii::app()->controller->protectEmail(param('adminEmail')).'</p>';
	}
	if(param('adminPhone')){
		echo '<p>'.tc('Телефон').': '.param('adminPhone').'</p>';
	}
	if(param('adminSkype')){
		echo '<p>'.tc('Skype').': '.param('adminSkype').'</p>';
	}
	if(param('adminICQ')){
		echo '<p>'.tc('ICQ').': '.param('adminICQ').'</p>';
	}
	if(param('adminAddress')){
		echo '<p>'.tc('Адрес').': '.param('adminAddress').'</p>';
	}
?>

<p><?php echo tc('Вы можете заполнить форму ниже для связи с нами.');?></p>


<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contactForm',
	'enableClientValidation'=>false,
));
?>
	<p class="note"><?php echo tc('Поля, отмеченные <span class="required">*</span>, являются обязательными для заполнения.');?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?> <br />
		<?php echo $form->textField($model,'name', array('size'=>60,'maxlength'=>128, 'class' => 'width240')); ?>
		<?php // echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?> <br />
		<?php echo $form->textField($model,'email', array('size'=>60,'maxlength'=>128, 'class' => 'width240')); ?>
		<?php // echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?> <br />
		<?php echo $form->textField($model,'phone', array('size'=>60,'maxlength'=>128, 'class' => 'width240')); ?>
		<?php // echo $form->error($model,'phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'body'); ?> <br />
		<?php echo $form->textArea($model,'body',array(/*'rows'=>3, 'cols'=>50,*/ 'class' => 'width500 height200')); ?>
		<?php // echo $form->error($model,'body'); ?>
	</div>

	<?php
	if (Yii::app()->user->isGuest){
	?>
		<div class="row">
			<?php echo $form->labelEx($model, 'verifyCode');?>
			<?php
			$cAction = '/menumanager/main/captcha';
			if($this->page == 'index'){
				$cAction = '/site/captcha';
			} elseif ($this->page == 'contactForm'){
				$cAction = '/contactform/main/captcha';
			}
			$this->widget('CCaptcha',
				array('captchaAction' => $cAction, 'buttonOptions' => array('style' => 'display:block;') )
			);?>
			<br/>
			<?php echo $form->textField($model, 'verifyCode');?><br/>
			<?php echo $form->error($model, 'verifyCode');?>
		</div>
	<?php
	}
	?>

	<div class="row buttons">
		<?php echo CHtml::submitButton(tc('Послать сообщение')); ?>
	</div>
<?php $this->endWidget(); ?>
</div>