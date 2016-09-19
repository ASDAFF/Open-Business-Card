<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Редактировать описание к изображению');
$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление галереей') => array('admin'),
	tc('Редактировать описание к изображению'),
);
$this->menu = array(
	array('label' => tc('Добавить изображение'), 'url' => array('create')),
	array('label' => tc('Удалить изображение'), 'url' => '#',
		'url'=>'#',
		'linkOptions'=>array(
			'submit'=>array('delete','id'=>$model->id),
			'confirm'=> tc("Вы действительно хотите удалить выбранный элемент?"),
			'csrf' => true,
		),
	)
);
$this->adminTitle = tc('Редактировать описание к изображению').':';

echo $this->renderPartial('/backend/_form', array('model'=>$model));