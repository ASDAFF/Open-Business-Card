<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Добавить категорию');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление каталогом товаров') => array('/catalog/backend/main/admin'),
	tc('Управление подкатегориями') => array('/catalog/backend/catalogsubcategory/admin'),
	tc('Добавить подкатегорию')
);

$this->adminTitle = tc('Добавить подкатегорию');

echo $this->renderPartial('_form', array('model'=>$model));