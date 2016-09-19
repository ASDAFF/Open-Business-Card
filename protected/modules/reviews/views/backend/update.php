<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Редактировать отзыв');
$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление отзывами') => array('admin'),
	tc('Редактировать отзыв'),
);
$this->menu = array(
	array('label' => tc('Добавить отзыв'), 'url' => array('create')),
	array('label' => tc('Удалить отзыв'), 'url' => '#',
		'url'=>'#',
		'linkOptions'=>array(
			'submit'=>array('delete','id'=>$model->id),
			'confirm'=> tc("Вы действительно хотите удалить выбранный элемент?"),
			'csrf' => true,
		),
	)
);
$this->adminTitle = tc('Редактировать отзыв');

echo $this->renderPartial('/backend/_form', array('model'=>$model));