<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Редактировать пункт меню');
$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление пунктами меню') => array('admin'),
	tc('Редактировать пункт меню'),
);

$this->adminTitle = tc('Редактировать пункт меню').': <i>'.CHtml::encode($model->title).'</i>';

echo $this->renderPartial('/backend/_form', array('model'=>$model));