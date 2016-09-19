<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Управление каталогом товаров');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление каталогом товаров'),
);

if (param('useTwoLevelCatalog', 0)) {
	$this->menu = array(
		array('label' => tc('Управление категориями'), 'url' => array('/catalog/backend/catalogcategory/admin')),
		array('label' => tc('Управление подкатегориями'), 'url' => array('/catalog/backend/catalogsubcategory/admin')),
		array('label' => tc('Управление наименованиями'), 'url' => array('/catalog/backend/catalog/admin')),
	);
}
else {
	$this->menu = array(
		array('label' => tc('Управление категориями'), 'url' => array('/catalog/backend/catalogcategory/admin')),
		array('label' => tc('Управление наименованиями'), 'url' => array('/catalog/backend/catalog/admin')),
	);
}

$this->adminTitle = tc('Управление каталогом товаров');