<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Добавить изображение');
$this->breadcrumbs=array(
	tc('Администрирование') => array('/admin/backend/main/index'),
	tc('Управление галереей') => array('admin'),
	tc('Добавить изображение'),
);
$this->adminTitle = tc('Добавить изображение');
?>

<div class="form">
	<?php $form=$this->beginWidget('CustomForm', array(
		'id'=>'Gallery-form',
		'enableClientValidation'=>false,
	)); ?>
	<div class="rowold">
		<?php $this->widget('ext.EAjaxUpload.EAjaxUpload',
		array(
				'id'=>'uploadFile',
				'config'=>array(
					'action'=>Yii::app()->createUrl('gallery/backend/gallery/upload'),
					'allowedExtensions'=>array("jpg","jpeg","gif","png"), //array("jpg","jpeg","gif","exe","mov" and etc...
					'categoryAllValues' => GalleryCategory::getAllCategories(true),
					'useGalleryGategory' => (param('useGalleryGategory')) ? true : false,
					'sizeLimit'=>2*1024*1024, // maximum file size in bytes
					//'minSizeLimit'=>10*1024*1024, // minimum file size in bytes
					'onComplete'=>"js:function(id, fileName, responseJSON){ message('Файл(ы) успешно загружены'); $('#submit-button').show(); }",
					'messages'=>array(
						'typeError'=>tc("{file} имеет неразрешённое расширение файла. Поддерживаются только {extensions}."),
						'sizeError'=>tc("{file} слишком большой, максимальный размер файла {sizeLimit}."),
						'minSizeError'=>tc("{file} слишком маленький, минимальный размер файла {minSizeLimit}."),
						'emptyError'=>tc("{file} пустой, пожалуйста выберите другой файл."),
						'onLeave'=>tc("Файл загружается, если вы покинете страницу, то закачка будет отменена.")
					),
					'showMessage'=>"js:function(message){ warning(message); }"
				)
		)); ?>
	</div>

	<div class="rowold buttons" id="submit-button" style="display: none;">
		<?php $this->widget('bootstrap.widgets.TbButton',
				array('buttonType'=>'submit',
					'type'=>'primary',
					'icon'=>'ok white',
					'label'=> tc('Сохранить описание'),
				)
		); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->