<?php if (param('useTwoLevelCatalog', 0)) : ?>
	<div class="rowold">
		<?php echo $form->labelEx($model,'id_category'); ?>
		<?php
			echo $form->dropDownList(
				$model,
				'id_category',
				CatalogCategory::getActiveCategories(),
				array(
					'class' => 'width250',
					'id' => 'id_category',
					'ajax' => array(
						'type'=>'GET',
						'url'=>$this->createUrl('/ajax/getSubCat'),
						'update'=>'#id_sub_category',
						'data'=>'js:"id_cat="+$("#id_category").val()'
					)
				)
			);
		?>
		<?php echo $form->error($model,'id_category'); ?>
	</div>

	<?php
		//при добавлении узнаём id первой категории
		if ($model->id_category) {
			$idCategory = $model->id_category;
		} else {
			$category_keys = array_keys(CatalogCategory::getActiveCategories());
			$idCategory = isset($category_keys[0]) ? $category_keys[0] : 0;
		}
	?>

	<div class="rowold">
		<?php echo $form->labelEx($model,'id_sub_category'); ?>
		<?php
			echo $form->dropDownList(
				$model,
				'id_sub_category',
				CatalogSubCategory::getSubCategoryArray($idCategory),
				array(
					'class' => 'width250',
					'id' => 'id_sub_category',

				)
			);
		?>
		<?php echo $form->error($model,'id_sub_category'); ?>
	</div>
<?php else: ?>
	<div class="rowold">
		<?php echo $form->labelEx($model,'id_category'); ?>
		<?php echo $form->dropDownList($model,'id_category', CatalogCategory::getActiveCategories(), array('class' => 'width150')); ?>
		<?php echo $form->error($model,'id_category'); ?>
	</div>
<?php endif; ?>

<div class="rowold">
	<?php
	$this->widget('application.modules.lang.components.langFieldWidget', array(
			'model' => $model,
			'field' => 'title',
			'type' => 'string',
		));
	?>
	<br/>
</div>

<div class="rowold">
	<?php
    $this->widget('application.modules.lang.components.langFieldWidget', array(
    		'model' => $model,
    		'field' => 'description',
            'type' => 'text-editor'
    	));
    ?>
	<br/>
</div>

<div class="rowold">
	<?php
    $this->widget('application.modules.lang.components.langFieldWidget', array(
    		'model' => $model,
    		'field' => 'cost',
            'type' => 'text-editor'
    	));
    ?>
</div>

<div class="rowold">
	<?php echo $form->labelEx($model,'img'); ?>
	<?php echo '<div class="padding-bottom10"><span class="label label-info">'.tc('Supported types of files').': '.$model->supportExt.'</span></div>';?>
	<?php
	$this->widget('CMultiFileUpload', array(
//				'model' => $model,
//				'attribute'=>'img',
			'name' => 'images',
			'accept' => "{$model->supportExtForUploader}",
			'options'=>array(
				'afterFileSelect'=>'function(e ,v ,m){
					var fileSize = e.files[0].size;
					if(fileSize>'.$model->fileMaxSize.'){
						alert("Maximum '.$model->fileMaxSize.'");
						$(".MultiFile-remove").click();
					}
					return true;
					}',
			),
		));
	?>
	<?php echo $form->error($model,'img'); ?>
</div>