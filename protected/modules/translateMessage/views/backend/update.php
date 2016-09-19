<?php
$this->breadcrumbs=array(
	tc('Управление переводами')=>array('admin'),
	tc('Редактирование перевода'),
);

$this->menu=array(
    array('label'=>tc('Управление переводами'), 'url'=>array('admin')),
    array('label'=>tc('Добавить перевод'), 'url'=>array('/translateMessage/backend/main/create')),
);

$this->adminTitle = tc('Редактирование перевода');
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>