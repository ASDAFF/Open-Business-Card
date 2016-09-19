<?php
$this->menu = array(
	array('label' => 'Добавить страницу', 'url' => array('create')),
	array('label' => 'Редактировать страницу', 'url' => array('update', 'id' => $model->id)),
	array('label' => 'Удалить страницу', 'url' => '#',
		'url'=>'#',
		'linkOptions'=>array(
			'submit'=>array('delete','id'=>$model->id),
			'confirm'=> tc("Вы действительно хотите удалить выбранный элемент?"),
			'csrf' => true,
		),
	),
);

$this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes'=>array(
		'id',
		array (
			'label' => CHtml::encode($model->getAttributeLabel('active')),
			'value' => ($model->active == InfoPages::STATUS_ACTIVE) ? 'Активно' : 'Неактивно',
			'template' => "<tr class=\"{class}\"><th>{label}</th><td>{value}</td></tr>\n"
		),
		array (
			'label' => CHtml::encode($model->getAttributeLabel('title')),
			'type' => 'raw',
			'value' => CHtml::encode($model->title),
			'template' => "<tr class=\"{class}\"><th>{label}</th><td>{value}</td></tr>\n"
		),
		array (
			'label' => CHtml::encode($model->getAttributeLabel('body')),
			'type' => 'raw',
			'value' => CHtml::decode($model->body),
			'template' => "<tr class=\"{class}\"><th>{label}</th><td>{value}</td></tr>\n"
		),
		array (
			'label' => CHtml::encode($model->getAttributeLabel('widget')),
			'value' => ($model->widget) ? InfoPages::getWidgetOptions($model->widget) : '',
			'template' => "<tr class=\"{class}\"><th>{label}</th><td>{value}</td></tr>\n"
		),
	),
));
