<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Просмотр новости');
$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление новостями') => array('admin'),
	tc('Просмотр новости'),
);
$this->menu = array(
	array('label' => tc('Добавить новость'), 'url' => array('create')),
	array('label' => tc('Редактировать новость'), 'url' => array('update', 'id' => $model->id)),
	array('label' => tc('Удалить новость'), 'url' => '#',
		'url'=>'#',
		'linkOptions'=>array(
			'submit'=>array('delete','id'=>$model->id),
			'confirm'=> tc("Вы действительно хотите удалить выбранный элемент?"),
			'csrf' => true,
		),
	),

);

$this->renderPartial('../view', array(
	'model' => $model,
));