<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Управление разделителями');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление прайс-листом') => array('/price/backend/main/admin'),
	tc('Управление разделителями')
);

$this->menu=array(
	array('label'=> tc('Добавить'), 'url'=>array('create')),
);

$this->adminTitle = tc('Управление разделителями');

$this->widget('CustomGridView', array(
	'id'=>'price-cat-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'afterAjaxUpdate' => 'function(){$("a[rel=\'tooltip\']").tooltip(); $("div.tooltip-arrow").remove(); $("div.tooltip-inner").remove(); reInstallSortable();}',
	'rowCssClassExpression'=>'"items[]_{$data->id}"',
	'rowHtmlOptionsExpression' => 'array("data-bid"=>"items[]_{$data->id}")',
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
			'value' => 'Yii::app()->controller->returnStatusHtml($data, "price-cat-grid", 1)',
			'headerHtmlOptions' => array('class'=>'width20'),
			'filter' => false,
			'sortable' => false,
		),
		array(
			'header' => $model->getAttributeLabel('name'),
			'name' => 'name_'.Yii::app()->language,
			'sortable' => false,
			//'filter' => false,
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
					'url'=>'Yii::app()->createUrl("/price/backend/cat/move", array("id"=>$data->id, "direction" => "up"))',
					'options' => array('class'=>'arrow_image_up'),
					'visible' => '$data->sorter > "'.$minSorter.'"',
					'click' => "js: function() { ajaxMoveRequest($(this).attr('href'), 'price-cat-grid'); return false;}",
				),
				'down' => array(
					'label' => tc('Переместить ниже'),
					'imageUrl' => $url = Yii::app()->assetManager->publish(
						Yii::getPathOfAlias('zii.widgets.assets.gridview').'/down.gif'
					),
					'url'=>'Yii::app()->createUrl("/price/backend/cat/move", array("id"=>$data->id, "direction" => "down"))',
					'options' => array('class'=>'arrow_image_down'),
					'visible' => '$data->sorter < "'.$maxSorter.'"',
					'click' => "js: function() { ajaxMoveRequest($(this).attr('href'), 'price-cat-grid'); return false;}",
				),
			),
			'afterDelete'=>'function(link,success,data){ if(success) $("#statusMsg").html(data); }'
		),
	),
)); ?>

<?php
	$this->renderPartial('//site/admin-select-items', array(
		'url' => '/price/backend/cat/itemsSelected',
		'id' => 'price-cat-grid',
		'model' => $model,
		'options' => array(
			'activate' => tc('Активировать'),
			'deactivate' => tc('Деактивировать'),
			'delete' => tc('Удалить'),
		),
	));
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
			$.fn.yiiGridView.update('price-cat-grid');
		}

		function installSortable() {
			$('#price-cat-grid table.items tbody').sortable({
				forcePlaceholderSize: true,
				forceHelperSize: true,
				items: 'tr',
				update : function () {
					serial = $('#price-cat-grid table.items tbody').sortable('serialize', {key: 'items[]', attribute: 'data-bid'}) + '&{$csrf_token_name}={$csrf_token}';
					$.ajax({
						'url': '" . $this->createUrl('/price/backend/cat/sortitems') . "',
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