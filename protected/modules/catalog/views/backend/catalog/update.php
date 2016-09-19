<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Редактировать наименование');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление каталогом товаров') => array('/catalog/backend/main/admin'),
	tc('Управление наименованиями') => array('/catalog/backend/catalog/admin'),
	tc('Редактировать'),
);

$this->menu=array(
	array('label'=> tc('Добавить наименование'), 'url'=>array('/catalog/backend/catalogcategory/create')),
	array('label'=> tc('Удалить наименование'), 'url'=>'#',
		'linkOptions'=>array(
			'submit'=>array('delete','id'=>$model->id),
			'confirm'=>tc("Вы действительно хотите удалить выбранный элемент?"),
			'csrf' => true,
		)
	),
);

$this->adminTitle = tc('Редактировать наименование').': <i>'.CHtml::encode($model->title).'</i>';

echo $this->renderPartial('_form', array('model'=>$model));

echo $this->renderPartial('_items',
	array('imagesProvider' => $imagesProvider,
		'catalogModel' => $model,
		'minSorterImage' => $minSorterImage,
		'maxSorterImage' => $maxSorterImage
	)
);