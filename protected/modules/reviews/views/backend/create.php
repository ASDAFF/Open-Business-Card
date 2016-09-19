<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Добавить отзыв');
$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление отзывами') => array('admin'),
	tc('Добавить отзыв'),
);
$this->adminTitle = tc('Добавить отзыв');

echo $this->renderPartial('/backend/_form', array('model'=>$model));