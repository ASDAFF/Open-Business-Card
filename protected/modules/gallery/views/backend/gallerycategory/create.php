<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Добавить категорию');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление галереей') => array('/gallery/backend/main/admin'),
	tc('Управление категориями') => array('/gallery/backend/gallerycategory/admin'),
	tc('Добавить категорию')
);

$this->adminTitle = tc('Добавить категорию');

echo $this->renderPartial('_form', array('model'=>$model));