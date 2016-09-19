<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Добавить разделитель');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление прайс-листом') => array('/price/backend/main/admin'),
	tc('Управление разделителями') => array('admin'),
	tc('Добавление'),
);

$this->menu=array(
	array('label'=> tc('Управление разделителями'), 'url'=>array('admin')),
);

$this->adminTitle = tc('Добавление');
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>