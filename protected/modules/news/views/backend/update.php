<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Редактировать новость');
$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление новостями') => array('admin'),
	tc('Редактировать новость'),
);
$this->menu = array(
	array('label' => tc('Добавить новость'), 'url' => array('create')),
	array('label' => tc('Удалить новость'), 'url' => '#',
		'url'=>'#',
		'linkOptions'=>array(
			'submit'=>array('delete','id'=>$model->id),
			'confirm'=> tc("Вы действительно хотите удалить выбранный элемент?"),
			'csrf' => true,
		),
	)
);
$this->adminTitle = tc('Редактировать новость').': <i>'.CHtml::encode($model->title).'</i>';

echo $this->renderPartial('/backend/_form', array('model'=>$model));