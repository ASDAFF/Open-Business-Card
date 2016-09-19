<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Управление категориями');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление каталогом товаров') => array('/catalog/backend/main/admin'),
	tc('Управление категориями'),
);

$this->menu=array(
	array('label'=>tc('Добавить категорию'), 'url'=>array('create')),
);

$this->adminTitle = tc('Список категорий');

$this->widget('CustomGridView', array(
	'id'=>'catalog-category-grid',
	'dataProvider'=>$model->search(),
	'afterAjaxUpdate' => 'function(){$("a[rel=\'tooltip\']").tooltip(); $("div.tooltip-arrow").remove(); $("div.tooltip-inner").remove(); reInstallSortable();}',
	'rowCssClassExpression'=>'"items[]_{$data->id}"',
	'rowHtmlOptionsExpression' => 'array("data-bid"=>"items[]_{$data->id}")',
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
			'value' => 'Yii::app()->controller->returnStatusHtml($data, "catalog-category-grid", 1)',
			'htmlOptions' => array('class' => 'width45'),
			'filter' => false,
		),
		array (
			'header' => $model->getAttributeLabel('title'),
			'name' => 'title_'.Yii::app()->language,
			'type' => 'raw',
			'value' => 'CHtml::encode($data->title)',
			'sortable' => false,

		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{up}{down}{update}{delete}',
			'deleteConfirmation' => tc("Вы действительно хотите удалить выбранный элемент?"),
			'htmlOptions' => array('class' => 'buttons_column'),
			'buttons' => array(
				'up' => array(
					'label' => tc('Переместить выше'),
					'imageUrl' => $url = Yii::app()->assetManager->publish(
						Yii::getPathOfAlias('zii.widgets.assets.gridview').'/up.gif'
					),
					'url'=>'Yii::app()->createUrl("/catalog/backend/catalogcategory/move", array("id"=>$data->id, "direction" => "up"))',
					'options' => array('class'=>'arrow_image_up'),
					'visible' => '$data->sorter > "'.$minSorter.'"',
					'click' => "js: function() { ajaxMoveRequest($(this).attr('href'), 'catalog-category-grid'); return false;}",
				),
				'down' => array(
					'label' => tc('Переместить ниже'),
					'imageUrl' => $url = Yii::app()->assetManager->publish(
						Yii::getPathOfAlias('zii.widgets.assets.gridview').'/down.gif'
					),
					'url'=>'Yii::app()->createUrl("/catalog/backend/catalogcategory/move", array("id"=>$data->id, "direction" => "down"))',
					'options' => array('class'=>'arrow_image_down'),
					'visible' => '$data->sorter < "'.$maxSorter.'"',
					'click' => "js: function() { ajaxMoveRequest($(this).attr('href'), 'catalog-category-grid'); return false;}",
				),
			),
		),
	),
));
?>

<?php
	if (CatalogCategory::model()->count() > 0) {
		$this->renderPartial('//site/admin-select-items', array(
			'url' => '/catalog/backend/catalogcategory/itemsSelected',
			'id' => 'catalog-category-grid',
			'model' => $model,
			'options' => array(
				'activate' => tc('Активировать'),
				'deactivate' => tc('Деактивировать'),
				'delete' => tc('Удалить'),
			),
		));
	}
?>

<?php

$csrf_token_name = Yii::app()->request->csrfTokenName;
$csrf_token = Yii::app()->request->csrfToken;

$cs = Yii::app()->getClientScript();
$cs->registerCoreScript('jquery.ui');

$str_js = "
		var fixHelper = function(e, ui) {
			ui.children().each(function() {
				$(this).width($(this).width());
			});
			return ui;
		};

		function reInstallSortable(id, data) {
			installSortable();
		}

		function updateGrid() {
			$.fn.yiiGridView.update('catalog-category-grid');
		}

		function installSortable() {
			$('#catalog-category-grid table.items tbody').sortable({
				forcePlaceholderSize: true,
				forceHelperSize: true,
				items: 'tr',
				update : function () {
					serial = $('#catalog-category-grid table.items tbody').sortable('serialize', {key: 'items[]', attribute: 'data-bid'}) + '&{$csrf_token_name}={$csrf_token}';
					$.ajax({
						'url': '" . $this->createUrl('/catalog/backend/catalogcategory/sortitems') . "',
						'type': 'post',
						'data': serial,
						'success': function(data){
							updateGrid();
						},
						'error': function(request, status, error){
							alert('We are unable to set the sort order at this time.  Please try again in a few minutes.');
						}
					});
				},
				helper: fixHelper
			}).disableSelection();
		}

		installSortable();
";

$cs->registerScript('sortable-project', $str_js);
