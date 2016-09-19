<?php
$this->breadcrumbs=array(
	tc('Управление языками')=>array('admin'),
	tc('Обновление языка'),
);

$this->menu=array(
	array('label'=>tc('Управление языками'), 'url'=>array('admin')),
	array('label'=>tc('Добавить язык'), 'url'=>array('/lang/backend/main/create')),
);

$this->adminTitle = tc('Обновление языка');
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>