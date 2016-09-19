<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Управление информационными страницами');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление информационными страницами'),
);

$this->menu = array(
	array('label' => tc('Добавить страницу'), 'url' => array('create')),
);

$this->adminTitle = tc('Управление информационными страницами');
?>

<div class="flash-notice">
	<?php echo tc('В этой секции Вы можете добавлять страницы, которые в дальнейшем можно либо разместить в меню, либо указывать ссылки в содержимом другой страницы.');?>
</div>

<?php $this->widget('CustomGridView', array(
	'id'=>'infopages-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'afterAjaxUpdate' => 'function(){$("a[rel=\'tooltip\']").tooltip(); $("div.tooltip-arrow").remove(); $("div.tooltip-inner").remove();}',
	'columns'=>array(
		array(
			'name' => 'active',
			'type' => 'raw',
			'value' => 'Yii::app()->controller->returnStatusHtml($data, "infopages-grid", 1, array(InfoPages::MAIN_PAGE_ID, InfoPages::PRIVATE_POLICY_PAGE_ID))',
			'htmlOptions' => array('class' => 'width45'),
			'filter' => false,
			'sortable' => false,
		),
		array(
			'header' => $model->getAttributeLabel('title'),
			'name'=>'title_'.Yii::app()->language,
			'type'=>'raw',
			'value'=>'CHtml::encode($data->title)',
			'sortable' => false,
		),
		array(
			'header' => tc('Ссылка'),
			'type'=>'raw',
			'value'=>'$data->getGridViewUrl()',
			'filter' => false,
			'sortable' => false,
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'deleteConfirmation' => tc("Вы действительно хотите удалить выбранный элемент?"),
			'template'=>'{view}{update}{delete}',
			'htmlOptions' => array('class'=>'buttons_column'),
			'buttons' => array(
				'delete' => array(
					'visible' => '$data->special == 0',
				),
			),
		),
	),
));