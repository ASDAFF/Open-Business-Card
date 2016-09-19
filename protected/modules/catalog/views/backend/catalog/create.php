<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Добавить наименование');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление каталогом товаров') => array('/catalog/backend/main/admin'),
	tc('Управление наименованиями') => array('/catalog/backend/catalog/admin'),
	tc('Добавить')
);

$this->adminTitle = tc('Добавить наименование');

echo $this->renderPartial('_form', array('model'=>$model)); 