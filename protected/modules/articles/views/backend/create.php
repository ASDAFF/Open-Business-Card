<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Добавить статью');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление статьями') => array('admin'),
	tc('Добавить статью'),
);

$this->adminTitle = tc('Добавить статью');

echo $this->renderPartial('/backend/_form', array('model'=>$model)); 