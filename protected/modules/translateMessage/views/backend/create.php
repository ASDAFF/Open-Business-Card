<?php
$this->breadcrumbs=array(
	tc('Управление переводами')=>array('admin'),
	tc('Добавить перевод'),
);


$this->menu=array(
    array('label'=>tc('Управление переводами'), 'url'=>array('admin')),
);

$this->adminTitle = tc('Добавить перевод');
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>