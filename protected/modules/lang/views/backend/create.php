<?php
$this->breadcrumbs=array(
	tc('Управление языками')=>array('admin'),
	tc('Добавить язык'),
);

$this->menu=array(
	array('label'=>tc('Управление языками'), 'url'=>array('admin')),
);

$this->adminTitle = tc('Добавить язык');
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>