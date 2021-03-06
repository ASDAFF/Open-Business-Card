<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Управление товарами');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление каталогом товаров') => array('/catalog/backend/main/admin'),
	tc('Управление наименованиями'),
);

$this->menu=array(
	array('label'=>tc('Добавить наименование'), 'url'=>array('create')),
);

$this->adminTitle = tc('Список наименований');

$columns = array(
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
		'value' => 'Yii::app()->controller->returnStatusHtml($data, "catalog-grid", 1)',
		'htmlOptions' => array('class' => 'width45'),
		'filter' => false,
	),
	array(
		'name'=>'img',
		'type'=>'raw',
		'value'=>'Yii::app()->controller->returnImagePrettyPhoto($data, "catalog-grid", 0, "'.param('maxWidthSmallThumbCatalog', 100).'", "'.param('maxHeightSmallThumbCatalog', 70).'")',
		'htmlOptions' => array('style' => 'height: '.param('maxHeightSmallThumbCatalog', 70).'px; width: '.param('maxWidthSmallThumbCatalog', 100).'px;'),
		'filter' => false,
		'sortable' => false,
	),
	array(
		'name' => 'id_category',
		'type' => 'raw',
		'value' => '($data->id_category && $data->catalogCategory) ? $data->catalogCategory->title : ""',
		'filter' => CatalogCategory::getActiveCategories(),
		'sortable' => false,
	),
);


if (param('useTwoLevelCatalog', 0)) {
	$columns[] = array(
		'name' => 'id_sub_category',
		'type' => 'raw',
		'value' => '($data->id_sub_category && $data->catalogSubCategory) ? $data->catalogSubCategory->title : ""',
		'filter' => CatalogSubCategory::getSubCategoryArray($model->id_category),
		'sortable' => false,
	);
}

$columns[] = array (
	'header' => $model->getAttributeLabel('title'),
	'name' => 'title_'.Yii::app()->language,
	'type' => 'raw',
	'value' => 'CHtml::encode($data->title)',
	'sortable' => false,
);

$columns[] = array (
	'header' => $model->getAttributeLabel('cost'),
	'name' => 'cost_'.Yii::app()->language,
	'type' => 'raw',
	'value' => 'CHtml::encode($data->cost)',
	'sortable' => false,
);

$columns[] = array(
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
			'url'=>'Yii::app()->createUrl("/catalog/backend/catalog/move", array("id"=>$data->id, "direction" => "up"))',
			'options' => array('class'=>'arrow_image_up'),
			'visible' => '$data->sorter > "'.$minSorter.'"',
			'click' => "js: function() { ajaxMoveRequest($(this).attr('href'), 'catalog-grid'); return false;}",
		),
		'down' => array(
			'label' => tc('Переместить ниже'),
			'imageUrl' => $url = Yii::app()->assetManager->publish(
				Yii::getPathOfAlias('zii.widgets.assets.gridview').'/down.gif'
			),
			'url'=>'Yii::app()->createUrl("/catalog/backend/catalog/move", array("id"=>$data->id, "direction" => "down"))',
			'options' => array('class'=>'arrow_image_down'),
			'visible' => '$data->sorter < "'.$maxSorter.'"',
			'click' => "js: function() { ajaxMoveRequest($(this).attr('href'), 'catalog-grid'); return false;}",
		),
	)
);

$this->widget('CustomGridView', array(
	'id'=>'catalog-grid',
	'dataProvider'=>$model->search(),
	'afterAjaxUpdate' => 'function(){$(".lightbox").prettyPhoto({social_tools: "", theme: "pp_default"}); $("a[rel=\'tooltip\']").tooltip(); $("div.tooltip-arrow").remove(); $("div.tooltip-inner").remove(); reInstallSortable();}',
	'rowCssClassExpression'=>'"items[]_{$data->id}"',
	'rowHtmlOptionsExpression' => 'array("data-bid"=>"items[]_{$data->id}")',
	'filter'=>$model,
	'columns'=>$columns,
));
?>

<?php
	if (Catalog::model()->count() > 0) {
		$this->renderPartial('//site/admin-select-items', array(
			'url' => '/catalog/backend/catalog/itemsSelected',
			'id' => 'catalog-grid',
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
			$.fn.yiiGridView.update('catalog-grid');
		}

		function installSortable() {
			$('#catalog-grid table.items tbody').sortable({
				forcePlaceholderSize: true,
				forceHelperSize: true,
				items: 'tr',
				update : function () {
					serial = $('#catalog-grid table.items tbody').sortable('serialize', {key: 'items[]', attribute: 'data-bid'}) + '&{$csrf_token_name}={$csrf_token}';
					$.ajax({
						'url': '" . $this->createUrl('/catalog/backend/catalog/sortitems') . "',
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