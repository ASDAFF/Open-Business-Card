<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Администрирование');

$this->breadcrumbs=array(
	tc('Администрирование'),
);

$this->adminTitle = tc('Администрирование');
?>

<div>
	<p><?php echo CHtml::link(tc('Управление меню'), array('/menumanager/backend/main/admin')) ?></p>
	<p><?php echo CHtml::link(tc('Новости'), array('/news/backend/main/admin')) ?></p>
	<p><?php echo CHtml::link(tc('Статьи'), array('/articles/backend/main/admin')) ?></p>
	<p><?php echo CHtml::link(tc('Галерея'), array('/gallery/backend/main/admin')) ?></p>
	<p><?php echo CHtml::link(tc('Каталог товаров'), array('/catalog/backend/main/admin')) ?></p>
	<p><?php echo CHtml::link(tc('Прайс-лист'), array('/price/backend/main/admin')) ?></p>
	<p><?php echo CHtml::link(tc('Настройки'), array('/configuration/backend/main/admin')) ?></p>
	<p><?php echo CHtml::link(tc('Информация'), array('/info/backend/main/admin')) ?></p>
	<p><?php echo CHtml::link(tc('Данные администратора'), array('/admininfo/backend/main/index')) ?></p>
</div>