<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Добавить страницу');
$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление информационными страницами') => array('admin'),
	tc('Добавить страницу'),
);
$this->adminTitle = tc('Добавить страницу');

echo $this->renderPartial('/backend/_form', array('model'=>$model));