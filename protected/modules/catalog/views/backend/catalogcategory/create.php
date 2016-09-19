<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Добавить категорию');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление каталогом товаров') => array('/catalog/backend/main/admin'),
	tc('Управление категориями') => array('/catalog/backend/catalogcategory/admin'),
	tc('Добавить категорию')
);

$this->adminTitle = tc('Добавить категорию');

echo $this->renderPartial('_form', array('model'=>$model)); 