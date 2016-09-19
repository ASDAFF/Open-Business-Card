<?php
	$this->widget('CustomGridView', array(
	'id'=>'images-grid',
	'dataProvider'=>$imagesProvider,
	'afterAjaxUpdate' => 'function(){$(".lightbox").prettyPhoto({social_tools: "", theme: "pp_default"}); $("a[rel=\'tooltip\']").tooltip(); $("div.tooltip-arrow").remove(); $("div.tooltip-inner").remove();}',
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
			'value' => 'Yii::app()->controller->returnStatusHtml($data, "images-grid", 1)',
			'htmlOptions' => array('class' => 'width20'),
			'filter' => false,
		),
		array(
            'name'=>'img',
			'type'=>'raw',
			'value'=>'Yii::app()->controller->returnImagePrettyPhoto($data, "images-grid", 0, "'.param('maxWidthSmallThumbCatalog', 100).'", "'.param('maxHeightSmallThumbCatalog', 70).'")',
			'htmlOptions' => array('style' => 'text-align: center; height: '.param('maxHeightSmallThumbCatalog', 70).'px; width: '.param('maxWidthSmallThumbCatalog', 100).'px;'),
			'filter' => false,
			'sortable' => false,
        ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{up}{down}{delete}',
			'deleteConfirmation' => tc("Вы действительно хотите удалить выбранный элемент?"),
			'htmlOptions' => array('class' => 'buttons_column'),
			'buttons' => array(
				'delete' => array(
					'url'=>'Yii::app()->createUrl("/catalog/backend/images/delete", array("id"=>$data->id))',
				),
				'up' => array(
					'label' => tc('Переместить выше'),
					'imageUrl' => $url = Yii::app()->assetManager->publish(
						Yii::getPathOfAlias('zii.widgets.assets.gridview').'/up.gif'
					),
					'url'=>'Yii::app()->createUrl("/catalog/backend/images/moveimage", array("id"=>$data->id, "direction" => "up"))',
					'options' => array('class'=>'arrow_image_up'),
					'visible' => '$data->sorter > "'.$minSorterImage.'"',
					'click' => "js: function() { ajaxMoveRequest($(this).attr('href'), 'images-grid'); return false;}",
				),
				'down' => array(
					'label' => tc('Переместить ниже'),
					'imageUrl' => $url = Yii::app()->assetManager->publish(
						Yii::getPathOfAlias('zii.widgets.assets.gridview').'/down.gif'
					),
					'url'=>'Yii::app()->createUrl("/catalog/backend/images/moveimage", array("id"=>$data->id, "direction" => "down"))',
					'options' => array('class'=>'arrow_image_down'),
					'visible' => '$data->sorter < "'.$maxSorterImage.'"',
					'click' => "js: function() { ajaxMoveRequest($(this).attr('href'), 'images-grid'); return false;}",
				),
			),
		),
	),
));
?>
<?php
	$criteria = new CDbCriteria();
	$criteria->addInCondition('pid', array($catalogModel->id));

	if (CatalogImages::model()->count($criteria) > 0) {
		$this->renderPartial('//site/admin-select-items', array(
			'url' => '/catalog/backend/images/itemsSelected',
			'id' => 'images-grid',
			'model' => $catalogModel,
			'options' => array(
				'activate' => tc('Активировать'),
				'deactivate' => tc('Деактивировать'),
				'delete' => tc('Удалить'),
			),
		));
	}
?>