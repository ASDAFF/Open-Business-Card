<?php
$this->breadcrumbs=array(
	'Управление разделителями' => array('admin'),
	'Редактирование',
);

$this->menu=array(
    array('label'=>'Управление разделителями', 'url'=>array('admin')),
    array('label'=> 'Добавить', 'url'=>array('create')),
	array('label' => 'Удалить',
		'url'=>'#',
		'linkOptions'=>array(
			'submit'=>array('delete','id'=>$model->id),
			'confirm'=> tc("Вы действительно хотите удалить выбранный элемент?"),
			'csrf' => true,
		),
	)
);

$this->adminTitle = 'Редактирование';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>