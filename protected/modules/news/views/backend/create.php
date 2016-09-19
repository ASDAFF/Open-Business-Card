<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Добавить новость');
$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление новостями') => array('admin'),
	tc('Добавить новость'),
);
$this->adminTitle = tc('Добавить новость');

echo $this->renderPartial('/backend/_form', array('model'=>$model)); 