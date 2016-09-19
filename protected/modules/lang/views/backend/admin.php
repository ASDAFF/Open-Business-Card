<?php
$this->breadcrumbs=array(
	tc('Управление языками'),
);

$this->menu = array(
	array('label'=>tc('Добавить язык'), 'url'=>array('create')),
);
$this->adminTitle = tc('Управление языками');

$this->widget('CustomGridView', array(
	'id'=>'langs-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'afterAjaxUpdate' => 'function(){$("a[rel=\'tooltip\']").tooltip(); $("div.tooltip-arrow").remove(); $("div.tooltip-inner").remove(); reInstallSortable();}',
	'rowCssClassExpression'=>'"items[]_{$data->id}"',
	'rowHtmlOptionsExpression' => 'array("data-bid"=>"items[]_{$data->id}")',
	'columns'=>array(
		/*array(
			'class'=>'CCheckBoxColumn',
			'id'=>'itemsSelected',
			'selectableRows' => '2',
			'htmlOptions' => array(
				'class'=>'center',
			),
		),*/
		array(
			'header' => tc('Статус'),
			'type' => 'raw',
			'value' => 'Yii::app()->controller->returnStatusHtml($data, "langs-grid", 0, $data->active ? array(Lang::getDefaultLangId()) : "")',
			'htmlOptions' => array('class' => 'width45'),
			'filter' => false,
			'sortable' => false,

		),
		array(
			'header' => tc('по умолчанию'),
			'type' => 'raw',
			'value' => '$data->getIsDefaultHtml(0)',
			'filter' => false,
			'sortable' => false,
			'htmlOptions' => array(
				'class'=>'width110 center',
			),
		),
		array(
			'name' => 'flag_img',
			'type' => 'raw',
			'value' => 'CHtml::image($data->getFlagUrl())',
			'sortable' => false,
			'filter' => false,
			'htmlOptions' => array(
				'class'=>'width100 center',
			),
		),
		array(
			'header' => tc('Язык'),
			'value' => '$data->name_'.Yii::app()->language,
			'sortable' => false,
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{up} {down} {update} {delete}',
			'deleteConfirmation' => tc('Вы действительно хотите удалить выбранный элемент?'),
				'htmlOptions' => array('class'=>'buttons_column'),
				'buttons' => array(
					'down' => array(
						'label' => tc('Переместить элемент ниже'),
						'imageUrl' => Yii::app()->assetManager->publish(
							Yii::getPathOfAlias('zii.widgets.assets.gridview').'/down.gif'
						),
						'url'=>'Yii::app()->createUrl("/lang/backend/main/move", array("id"=>$data->id, "direction" => "down", "catid" => "0"))',
						'options' => array('class'=>'infopages_arrow_image_up'),

						'visible' => '$data->sorter < "'.$maxSorter.'"',
						'click' => "js: function() { ajaxMoveRequest($(this).attr('href'), 'langs-grid'); return false;}",
					),
					'up' => array(
						'label' => tc('Переместить элемент выше'),
						'imageUrl' => Yii::app()->assetManager->publish(
							Yii::getPathOfAlias('zii.widgets.assets.gridview').'/up.gif'
						),
						'url'=>'Yii::app()->createUrl("/lang/backend/main/move", array("id"=>$data->id, "direction" => "up", "catid" => "0"))',
						'options' => array('class'=>'infopages_arrow_image_down'),
						'visible' => '$data->sorter > "'.$minSorter.'"',
						'click' => "js: function() { ajaxMoveRequest($(this).attr('href'), 'langs-grid'); return false;}",
					),
					'delete' => array(
						'visible' => '$data->name_iso != Lang::getDefaultLang()'
					)
				),
		),
	),
));

Yii::app()->clientScript->registerScript('setDefLang', "
	function changeDefault(id){
		$.ajax({
			type: 'POST',
			url: '".Yii::app()->request->baseUrl."/lang/backend/main/setDefault',
			data: { 'id' : id },
			success: function(msg){
				$.fn.yiiGridView.update('langs-grid');
		}
		});
		return;
	}",
	CClientScript::POS_END);
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
			$.fn.yiiGridView.update('langs-grid');
		}

		function installSortable() {
			$('#langs-grid table.items tbody').sortable({
				forcePlaceholderSize: true,
				forceHelperSize: true,
				items: 'tr',
				update : function () {
					serial = $('#langs-grid table.items tbody').sortable('serialize', {key: 'items[]', attribute: 'data-bid'}) + '&{$csrf_token_name}={$csrf_token}';
					$.ajax({
						'url': '" . $this->createUrl('/lang/backend/main/sortitems') . "',
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