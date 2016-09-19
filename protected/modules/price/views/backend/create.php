<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Добавить наименование');
$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление прайс-листом') => array('admin'),
	tc('Добавить наименование'),
);
$this->adminTitle = tc('Добавить наименование');

echo $this->renderPartial('/backend/_form', array('model'=>$model)); 