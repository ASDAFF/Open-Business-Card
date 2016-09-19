<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Управление настройками');

$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление настройками'),
);

$this->adminTitle = tc('Управление настройками');

Yii::app()->clientScript->registerScript('ajaxSetStatus', "
	function ajaxSetStatus(elem, id){
		$.ajax({
			url: $(elem).attr('href'),
			success: function(){
				$('#'+id).yiiGridView.update(id);
			}
		});
	}
    ",
    CClientScript::POS_HEAD);

$this->widget('CustomGridView', array(
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'id'=>'config-table',
	'columns'=>array(
        /*array(
            'header'=>tc('Настройки'),
            'value' => '$data->section',
			'htmlOptions' => array('class' => 'width100'),
            'filter' => CHtml::dropDownList('section_filter', $currentSection, $this->getSections()),
        ),*/
		array(
			'header' => $model->getAttributeLabel('title'),
			'name' => 'title_'.Yii::app()->language,
			'type'=>'raw',
			'htmlOptions' => array('class' => 'width250'),
			'sortable' => false,
			'filter' => false,
		),
		array(
			'name'=>'value',
            'type'=>'raw',
			'value' => 'ConfigurationModel::getAdminValue($data)',
			'htmlOptions' => array('class' => 'width150'),
			'sortable' => false,
			'filter' => false,
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template' => '{update}',
            'buttons' => array(
				'update' => array(
					'visible' => 'ConfigurationModel::getVisible($data->type)'
				)
			),
			'htmlOptions' => array('class' => 'buttons_column'),
		),
	),
));