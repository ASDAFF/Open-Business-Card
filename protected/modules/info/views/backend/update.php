<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Редактировать информацию');
$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление информацией') => array('admin'),
	tc('Редактировать информацию'),
);

$this->adminTitle = tc('Редактировать информацию').':';

echo $this->renderPartial('/backend/_form', array('model'=>$model));