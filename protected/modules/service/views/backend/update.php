<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Обслуживание сайта');
$this->adminTitle = tc('Обслуживание сайта');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Обслуживание сайта') => array('admin'),
);

$this->menu = array(array());

echo $this->renderPartial('/backend/_form', array('model'=>$model));