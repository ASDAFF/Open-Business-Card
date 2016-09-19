<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Редактировать наименование');
$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление прайс-листом') => array('admin'),
	tc('Редактировать наименование'),
);
$this->menu = array(
	array('label' => tc('Добавить наименование'), 'url' => array('create')),
	array('label' => tc('Удалить наименование'), 'url' => '#',
		'url'=>'#',
		'linkOptions'=>array(
			'submit'=>array('delete', 'id'=>$model->id),
			'confirm'=> tc("Вы действительно хотите удалить выбранный элемент?"),
			'csrf' => true,
		),
	)
);
$this->adminTitle = tc('Редактировать наименование').': <i>'.CHtml::encode($model->name).'</i>';

echo $this->renderPartial('_form', array('model'=>$model));