<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Редактировать категорию');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление галереей') => array('/gallery/backend/main/admin'),
	tc('Управление категориями') => array('/gallery/backend/gallerycategory/admin'),
	tc('Редактировать категорию'),
);

$this->menu=array(
	array('label'=> tc('Добавить категорию'), 'url'=>array('/gallery/backend/gallerycategory/create')),
	array('label'=> tc('Удалить категорию'), 'url'=>'#',
		'linkOptions'=>array(
			'submit'=>array('delete','id'=>$model->id),
			'confirm'=>tc("Вы действительно хотите удалить выбранный элемент?"),
			'csrf' => true,
		)
	),

);

$this->adminTitle = tc('Редактировать категорию').': <i>'.CHtml::encode($model->title).'</i>';

echo $this->renderPartial('_form', array('model'=>$model));