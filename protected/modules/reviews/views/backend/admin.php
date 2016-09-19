<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Управление отзывами');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление отзывами'),
);

$this->menu = array(
	array('label' => tc('Добавить отзыв'), 'url' => array('create')),
);

$this->adminTitle = tc('Управление отзывами');

$this->widget('CustomGridView', array(
	'id'=>'reviews-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'afterAjaxUpdate' => 'function(){$("a[rel=\'tooltip\']").tooltip(); $("div.tooltip-arrow").remove(); $("div.tooltip-inner").remove();}',
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
			'value' => 'Yii::app()->controller->returnStatusHtml($data, "reviews-grid", 1)',
			'htmlOptions' => array('class'=>'infopages_status_column'),
			'filter' => false,
			'sortable' => true,
		),
		array (
			'name'=>'name',
			//'htmlOptions' => array('class'=>'width120'),
			'sortable' => false,
			'type' => 'raw',
			'value' => 'CHtml::encode($data->name)',
		),
		array (
			'name'=>'body',
			'sortable' => false,
			'type' => 'raw',
			'value' => 'CHtml::link(CHtml::encode(truncateText($data->body)),array("/reviews/backend/main/view","id" => $data->id))',
		),
		array (
			'name' => 'date_created',
			'headerHtmlOptions' => array('style' => 'width:130px;'),
			'filter' => false,
			'sortable' => false,
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}{update}{delete}',
			'deleteConfirmation' => tc("Вы действительно хотите удалить выбранный элемент?"),
			'viewButtonUrl' => "Yii::app()->createUrl('/reviews/backend/main/view', array('id' => \$data->id))",
			'htmlOptions' => array('class'=>'buttons_column'),
			'buttons' => array(
				'up' => array(
					'label' => tc('Переместить выше'),
					'imageUrl' => $url = Yii::app()->assetManager->publish(
						Yii::getPathOfAlias('zii.widgets.assets.gridview').'/up.gif'
					),
					'url'=>'Yii::app()->createUrl("/reviews/backend/main/move", array("id"=>$data->id, "direction" => "up"))',
					'options' => array('class'=>'arrow_image_up'),
					'visible' => '$data->sorter > "'.$minSorter.'"',
				),
				'down' => array(
					'label' => tc('Переместить ниже'),
					'imageUrl' => $url = Yii::app()->assetManager->publish(
						Yii::getPathOfAlias('zii.widgets.assets.gridview').'/down.gif'
					),
					'url'=>'Yii::app()->createUrl("/reviews/backend/main/move", array("id"=>$data->id, "direction" => "down"))',
					'options' => array('class'=>'arrow_image_down'),
					'visible' => '$data->sorter < "'.$maxSorter.'"',
				),
			),
		),
	),
));

$this->renderPartial('//site/admin-select-items', array(
	'url' => '/reviews/backend/main/itemsSelected',
	'id' => 'reviews-grid',
	'model' => $model,
	'options' => array(
		'activate' => tc('Активировать'),
		'deactivate' => tc('Деактивировать'),
		'delete' => tc('Удалить'),
	),
));
?>