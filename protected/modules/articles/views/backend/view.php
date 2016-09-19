<?php
$this->pageTitle=Yii::app()->name;
$this->menu = array(
	array('label' => 'Добавить статью', 'url' => array('create')),
	array('label' => 'Редактировать статью', 'url' => array('update', 'id' => $model->id)),
	array('label' => 'Удалить статью', 'url' => '#',
		'url'=>'#',
		'linkOptions' =>array(
			'submit' =>array('delete','id'=>$model->id),
			'confirm' => tc("Вы действительно хотите удалить выбранный элемент?"),
			'csrf' => true,
		),
	),

);

$this->adminTitle = $model['title'];

$this->renderPartial('../view', array(
		'model' => $model,
		'articles' => $articles,
));

?>
