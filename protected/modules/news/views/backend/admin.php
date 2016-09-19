<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Управление новостями');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление новостями'),
);

$this->menu = array(
	array('label' => tc('Добавить новость'), 'url' => array('create')),
);

$this->adminTitle = tc('Управление новостями');

$this->widget('CustomGridView', array(
	'id'=>'news-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'CCheckBoxColumn',
			'id'=>'itemsSelected',
			'selectableRows' => '2',
			'htmlOptions' => array(
				'class'=>'center',
			),
		),
		array(
			'name' => 'active',
			'type' => 'raw',
			'value' => 'Yii::app()->controller->returnStatusHtml($data, "news-grid", 1)',
			'htmlOptions' => array('class' => 'width45'),
			'filter' => false,
		),
		array(
			'header' => $model->getAttributeLabel('title'),
			'name' => 'title_'.Yii::app()->language,
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::encode($data->title), $data->url)',
			'sortable' => false,
		),
		array(
			'name'=>'dateCreatedAdmin',
			'type'=>'raw',
			'htmlOptions' => array('style' => 'width:130px;'),
			'filter' => false,
			'sortable' => false,
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'deleteConfirmation' => tc("Вы действительно хотите удалить выбранный элемент?"),
			'viewButtonUrl' => '$data->url',
			'htmlOptions' => array('class' => 'buttons_column'),
		),
	),
));
?>

<?php
	if (News::model()->count() > 0) {
		$this->renderPartial('//site/admin-select-items', array(
			'url' => '/news/backend/main/itemsSelected',
			'id' => 'news-grid',
			'model' => $model,
			'options' => array(
				'activate' => tc('Активировать'),
				'deactivate' => tc('Деактивировать'),
				'delete' => tc('Удалить'),
			),
		));
	}
?>