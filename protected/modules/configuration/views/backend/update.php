<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Редактировать новость');
$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление настройками') => array('admin'),
	tc('Редактировать настройки'),
);

$this->adminTitle = tc('Редактировать параметр настройки');
?>

<div class="form">

	<?php $form=$this->beginWidget('CustomForm', array(
		'id'=>$this->modelName.'-form',
		'enableAjaxValidation'=>false,
	)); ?>

	<p class="note"><?php echo tc('Поля, отмеченные <span class="required">*</span>, являются обязательными для заполнения.');?></p>
	
	<?php
		echo '<div class="rowold">';
		echo CHtml::activeLabel($model, 'value', array('required' => true));
		if($model->type == 'enum' && $list = ConfigurationModel::getEnumListForKey($model->name)){
			echo $form->dropDownList($model, 'value', $list, array('class' => 'width450', 'id' => 'config_value'));
		} 
		else {
			echo $form->textArea($model, 'value', array('class' => 'width450', 'id' => 'config_value'));
		}
		echo $form->error($model, 'value');
		echo '</div>';
    ?>

	<div class="rowold buttons">
		<?php 
			$this->widget('bootstrap.widgets.TbButton',
				array('buttonType'=>'submit',
					'type'=>'primary',
					'icon'=>'ok white',
					'label'=> tc('Сохранить'),
				)
			); 
		?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->