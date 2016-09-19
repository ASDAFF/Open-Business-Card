<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Управление подкатегориями');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление каталогом товаров') => array('/catalog/backend/main/admin'),
	tc('Управление подкатегориями'),
);

$this->menu=array(
	array('label'=>tc('Добавить подкатегорию'), 'url'=>array('create')),
);

$this->adminTitle = tc('Список подкатегорий');

$this->widget('CustomGridView', array(
	'id'=>'catalog-subcategory-grid',
	'dataProvider'=>$model->search(),
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
			'value' => 'Yii::app()->controller->returnStatusHtml($data, "catalog-subcategory-grid", 1)',
			'htmlOptions' => array('class' => 'width45'),
			'filter' => false,
		),
		array(
			'name'=>'id_category',
			'value'=>'($data->category) ? $data->category->title : ""',
			'filter' => CatalogCategory::getActiveCategories(),
			'sortable' => false,
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
			'template'=>'{update}{delete}',
			'deleteConfirmation' => tc("Вы действительно хотите удалить выбранный элемент?"),
			'htmlOptions' => array('class' => 'buttons_column'),
		),
	),
));
?>

<?php
	if (CatalogSubCategory::model()->count() > 0) {
		$this->renderPartial('//site/admin-select-items', array(
			'url' => '/catalog/backend/catalogsubcategory/itemsSelected',
			'id' => 'catalog-subcategory-grid',
			'model' => $model,
			'options' => array(
				'activate' => tc('Активировать'),
				'deactivate' => tc('Деактивировать'),
				'delete' => tc('Удалить'),
			),
		));
	}
?>
