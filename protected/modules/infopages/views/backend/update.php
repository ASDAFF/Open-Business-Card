<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Редактировать страницу');
$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление информационными страницами') => array('admin'),
	tc('Редактировать страницу'),
);

$this->menu = array(
	array('label' => tc('Добавить страницу'), 'url' => array('create')),
	array('label' => tc('Удалить страницу'), 'url' => '#',
		'url'=>'#',
		'linkOptions'=>array(
			'submit'=>array('delete','id'=>$model->id),
			'confirm'=> tc("Вы действительно хотите удалить выбранный элемент?"),
			'csrf' => true,
		),
	)
);
$this->adminTitle = tc('Редактировать страницу').': <i>'.CHtml::encode($model->title).'</i>';

echo $this->renderPartial('/backend/_form', array('model'=>$model));