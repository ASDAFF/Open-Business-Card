<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Статьи');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление статьями') =>array('admin'),
);

$this->menu=array(
	array('label' => tc('Управление статьями'), 'url'=>array('/articles/backend/main/admin')),
	array('label'=> tc('Добавить статью'), 'url'=>array('/articles/backend/main/create')),
);

$this->renderPartial('../index', array(
		'pages' => $pages,
		'articles' => $articles,
));