<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Редактировать статью');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление статьями') => array('admin'),
	tc('Редактировать статью'),
);

$this->menu=array(
	array('label'=> tc('Добавить статью'), 'url'=>array('/articles/backend/main/create')),
	array('label'=> tc('Удалить статью'), 'url'=>'#',
		'linkOptions'=>array(
			'submit'=>array('delete','id'=>$model->id),
			'confirm'=>tc("Вы действительно хотите удалить выбранный элемент?"),
			'csrf' => true,
		)
	),

);

$this->adminTitle = tc('Редактировать статью').': <i>'.CHtml::encode($model->title).'</i>';

echo $this->renderPartial('/backend/_form', array('model'=>$model));