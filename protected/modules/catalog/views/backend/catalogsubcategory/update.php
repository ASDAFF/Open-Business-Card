<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Редактировать категорию');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление каталогом товаров') => array('/catalog/backend/main/admin'),
	tc('Управление подкатегориями') => array('/catalog/backend/catalogsubcategory/admin'),
	tc('Редактировать подкатегорию'),
);

$this->menu=array(
	array('label'=> tc('Добавить подкатегорию'), 'url'=>array('/catalog/backend/catalogcategory/create')),
	array('label'=> tc('Удалить подкатегорию'), 'url'=>'#',
		'linkOptions'=>array(
			'submit'=>array('delete','id'=>$model->id),
			'confirm'=>tc("Вы действительно хотите удалить выбранный элемент?"),
			'csrf' => true,
		)
	),

);

$this->adminTitle = tc('Редактировать подкатегорию').': <i>'.CHtml::encode($model->title).'</i>';

echo $this->renderPartial('_form', array('model'=>$model));