<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Добавить страницу');
$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление пунктами меню') => array('admin'),
	tc('Добавить меню'),
);
$this->adminTitle = tc('Добавить меню');

echo $this->renderPartial('/backend/_form', array('model'=>$model));