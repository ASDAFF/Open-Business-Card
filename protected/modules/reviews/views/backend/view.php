<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Просмотр отзыва');
$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление отзывами') => array('admin'),
	tc('Просмотр отзыва'),
);
$this->menu = array(
	array('label' => tc('Добавить отзыв'), 'url' => array('create')),
	array('label' => tc('Редактировать отзыв'), 'url' => array('update', 'id' => $model->id)),
	array('label' => tc('Удалить отзыв'), 'url' => '#',
		'url'=>'#',
		'linkOptions'=>array(
			'submit'=>array('delete','id'=>$model->id),
			'confirm'=> tc("Вы действительно хотите удалить выбранный элемент?"),
			'csrf' => true,
		),
	),

);

$this->adminTitle = $model['name'];

$this->widget('bootstrap.widgets.TbDetailView',array(
	'data' => $model,
	'attributes'=>array(
		'id',
		'name',
		array(
			'label' => CHtml::encode($model->getAttributeLabel('body')),
			'value' => CHtml::encode($model->body),
			'type' => 'raw',
			'template' => "<tr class=\"{class}\"><th>{label}</th><td>{value}</td></tr>\n"
		),
		'date_created',
	))
);
?>