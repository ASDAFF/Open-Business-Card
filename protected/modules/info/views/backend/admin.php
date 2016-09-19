<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Управление информацией');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление информацией'),
);

$this->adminTitle = tc('Управление информацией');

$this->widget('CustomGridView', array(
	'id'=>'info-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' => 'active',
			'type' => 'raw',
			'value' => 'Yii::app()->controller->returnStatusHtml($data, "info-grid", 1, array('.Info::TYPE_ERROR404.', '.Info::TYPE_SLOGAN.'))',
			'htmlOptions' => array('class' => 'width45'),
			'filter' => false,
		),
		array(
			'name'=>'type',
			'type'=>'raw',
			'value'=>'CHtml::encode(Info::getTypeName($data->type))',
			'filter' => false,
			'sortable' => false,
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update}',
			'htmlOptions' => array('class' => 'buttons_column'),
		),
	),
));