<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Управление прайс-листом');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление прайс-листом'),
);

$this->menu = array(
	array('label' => tc('Добавить наименование'), 'url' => array('create')),
	array('label' => tc('Добавить разделитель'), 'url' => array('backend/cat/create')),
);

$this->adminTitle = tc('Управление прайс-листом');

$this->widget('ext.groupgridview.BootGroupGridView', array(
	'id'=>'price-grid',
	'dataProvider'=>$model->search(),
	//'mergeColumns' => array('cat_id'),
	'extraRowColumns' => array('cat_id'),
	'mergeType' => 'nested',
	//'rowCssClassExpression' => '$data->getRowCssClass()',
	'afterAjaxUpdate' => 'function(){$("a[rel=\'tooltip\']").tooltip(); $("div.tooltip-arrow").remove(); $("div.tooltip-inner").remove();}',
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
			'value' => 'Yii::app()->controller->returnStatusHtml($data, "price-grid", 1)',
			'htmlOptions' => array('class' => 'width45'),
			'filter' => false,
			'sortable' => false,
		),
		array(
			'name'=>'cat_id',
			'value'=>'($data->cat) ? $data->cat->name : ""',
			'filter' =>PriceCategory::getPriceCategory(),
			'sortable' => false,
		),
		array(
			'header' => $model->getAttributeLabel('name'),
			'name' => 'name_'.Yii::app()->language,
			'type' => 'raw',
			'value' => '$data->name',
			/*'htmlOptions' => array('class' => 'width300'),*/
			'sortable' => false,
			//'filter' => false,
		),
		array(
			'header' => $model->getAttributeLabel('cost'),
			'name' => 'cost_'.Yii::app()->language,
			'type' => 'raw',
			'value' => '$data->cost',
			/*'htmlOptions' => array('class' => 'width300'),*/
			'sortable' => false,
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{up}{down}{update}{delete}',
			'deleteConfirmation' => tc("Вы действительно хотите удалить выбранный элемент?"),
			'htmlOptions' => array('class'=>'buttons_column'),
			'buttons' => array(
				'up' => array(
					'label' => tc('Переместить выше'),
					'imageUrl' => $url = Yii::app()->assetManager->publish(
						Yii::getPathOfAlias('zii.widgets.assets.gridview').'/up.gif'
					),
					'url'=>'Yii::app()->createUrl("/price/backend/main/move", array("id"=>$data->id, "direction" => "up", "catid"=>$data->cat_id))',
					'options' => array('class'=>'arrow_image_up'),
					'visible' => '$data->sorter >  Yii::app()->controller->minSorters[$data->cat_id]',
					'click' => "js: function() { ajaxMoveRequest($(this).attr('href'), 'price-grid'); return false;}",
				),
				'down' => array(
					'label' => tc('Переместить ниже'),
					'imageUrl' => $url = Yii::app()->assetManager->publish(
						Yii::getPathOfAlias('zii.widgets.assets.gridview').'/down.gif'
					),
					'url'=>'Yii::app()->createUrl("/price/backend/main/move", array("id"=>$data->id, "direction" => "down", "catid"=>$data->cat_id))',
					'options' => array('class'=>'arrow_image_down'),
					'visible' => '$data->sorter < Yii::app()->controller->maxSorters[$data->cat_id]',
					'click' => "js: function() { ajaxMoveRequest($(this).attr('href'), 'price-grid'); return false;}",
				),
			),
			'afterDelete'=>'function(link,success,data){ if(success) $("#statusMsg").html(data); }'
		),
	),
));
?>

<?php
	if (Price::model()->count() > 0) {
		$this->renderPartial('//site/admin-select-items', array(
			'url' => '/price/backend/main/itemsSelected',
			'id' => 'price-grid',
			'model' => $model,
			'options' => array(
				'activate' => tc('Активировать'),
				'deactivate' => tc('Деактивировать'),
				'delete' => tc('Удалить'),
			),
		));
	}
?>