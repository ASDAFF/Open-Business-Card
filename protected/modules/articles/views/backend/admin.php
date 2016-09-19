<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Управление статьями');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление статьями'),
);

$this->menu=array(
	array('label'=>tc('Добавить статью'), 'url'=>array('/articles/backend/main/create')),
);

$this->adminTitle = tc('Управление статьями');

$this->widget('CustomGridView', array(
	'id'=>'articles-grid',
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
			'value' => 'Yii::app()->controller->returnStatusHtml($data, "articles-grid", 1)',
			'htmlOptions' => array('class' => 'width45'),
			'filter' => false,
		),
		array (
			'header' => $model->getAttributeLabel('title'),
			'name' => 'title_'.Yii::app()->language,
			'type' => 'raw',
			'value' => 'CHtml::link(CHtml::encode($data->title),array("/articles/backend/main/view","id" => $data->id))',
			'sortable' => false,
		),
		array (
			'header' => $model->getAttributeLabel('page_body'),
			'name' => 'page_body_'.Yii::app()->language,
			'type' => 'raw',
			'value' => 'CHtml::decode(truncateText($data->page_body))',
			'filter' => false,
			'sortable' => false,
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{up}{down}{view}{update}{delete}',
			'deleteConfirmation' => tc("Вы действительно хотите удалить выбранный элемент?"),
			'viewButtonUrl' => '$data->url',
			'htmlOptions' => array('class' => 'buttons_column'),
			'buttons' => array(
				'up' => array(
					'label' => tc('Переместить выше'),
					'imageUrl' => $url = Yii::app()->assetManager->publish(
						Yii::getPathOfAlias('zii.widgets.assets.gridview').'/up.gif'
					),
					'url'=>'Yii::app()->createUrl("/articles/backend/main/move", array("id"=>$data->id, "direction" => "up"))',
					'options' => array('class'=>'arrow_image_up'),
					'visible' => '$data->sorter > "'.$minSorter.'"',
					'click' => "js: function() { ajaxMoveRequest($(this).attr('href'), 'articles-grid'); return false;}",
				),
				'down' => array(
					'label' => tc('Переместить ниже'),
					'imageUrl' => $url = Yii::app()->assetManager->publish(
						Yii::getPathOfAlias('zii.widgets.assets.gridview').'/down.gif'
					),
					'url'=>'Yii::app()->createUrl("/articles/backend/main/move", array("id"=>$data->id, "direction" => "down"))',
					'options' => array('class'=>'arrow_image_down'),
					'visible' => '$data->sorter < "'.$maxSorter.'"',
					'click' => "js: function() { ajaxMoveRequest($(this).attr('href'), 'articles-grid'); return false;}",
				),
			),
		),
	),
));
?>

<?php
	if (Articles::model()->count() > 0) {
		$this->renderPartial('//site/admin-select-items', array(
			'url' => '/articles/backend/main/itemsSelected',
			'id' => 'articles-grid',
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
			$.fn.yiiGridView.update('articles-grid');
		}

		function installSortable() {
			$('#articles-grid table.items tbody').sortable({
				forcePlaceholderSize: true,
				forceHelperSize: true,
				items: 'tr',
				update : function () {
					serial = $('#articles-grid table.items tbody').sortable('serialize', {key: 'items[]', attribute: 'data-bid'}) + '&{$csrf_token_name}={$csrf_token}';
					$.ajax({
						'url': '" . $this->createUrl('/articles/backend/main/sortitems') . "',
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