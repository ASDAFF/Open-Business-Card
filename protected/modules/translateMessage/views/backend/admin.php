<?php

$this->pageTitle=Yii::app()->name . ' - ' . tc('Управление переводами');

$this->menu=array(
	array('label'=>tc('Добавить перевод'), 'url'=>array('create')),
);

$this->adminTitle = tc('Управление переводами', 'translateMessage');

$this->widget('CustomGridView', array(
	'id'=>'translate-message-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'afterAjaxUpdate' => 'function(){$("a[rel=\'tooltip\']").tooltip(); $("div.tooltip-arrow").remove(); $("div.tooltip-inner").remove();}',
	'columns'=>array(
		array(
			'name' => 'status',
			'filter' => TranslateMessage::getStatusArray(),
			'type' => 'raw',
			'value' => '$data->getStatusHtml()',
			'htmlOptions' => array(
				'class'=>'width120',
			),
		),
		array(
			'name' => 'category',
			'filter' => TranslateMessage::getCategoryFilter(),
			'htmlOptions' => array(
				'class'=>'width200',
			),
		),
		'message',
		array(
			'class' => 'editable.EditableColumn',
			'header' => $model->getAttributeLabel('translation'),
			'name' => 'translation_'.Yii::app()->language,
			'value' => '$data->getStrByLang("translation")',
			'editable' => array(
				'type' => 'textarea',
				'url' => Yii::app()->controller->createUrl('/translateMessage/backend/main/ajaxEditColumn', array('model' => 'TranslateMessage', 'field' => 'translation_'.Yii::app()->language)),
				'placement' => 'right',
				'emptytext' => '',
				'savenochange' => 'true',
				'title' => tc('Значение константы (перевод)'),
				'options' => array(
					'ajaxOptions' => array('dataType' => 'json')
				),
				'success' => 'js: function(response, newValue) {
					if (response.msg == "ok") {
						message("'.tc("Success").'");
					}
					else if (response.msg == "save_error") {
						var newValField = "'.tc("Ошибка. Повторите запрос позднее").'";

						return newValField;
					}
					else if (response.msg == "no_value") {
						var newValField = "'.tc("Введите требуемое значение").'";

						return newValField;
					}
				}',
			),
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'deleteConfirmation' => tc('Вы действительно хотите удалить выбранный элемент?'),
			'template'=>'{update} {delete}',
		),
	),
)); ?>
