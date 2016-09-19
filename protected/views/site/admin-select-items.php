<div id="confirmDiv"></div>

<div class='gridview-control-line'>
	<?php
		echo CHtml::beginForm($this->createUrl($url), 'post', array('id'=>'itemsSelected-form'));
	?>
	<img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/img/arrow_ltr.png"/>
	<?php
		echo '<span>'.tc('С отмеченными').':</span> ';
		echo CHtml::DropDownList('workWithItemsSelected', $model->WorkItemsSelected, $options).' ';

		echo CHtml::button(
			tc('Выполнить'),
			array(
				'id' => 'control-gridview-item-selected',
				'class' => 'btn btn-primary',
				'onclick' => "
					$(\"#confirmDiv\").confirmModal({
						heading: 'Запрос на подтверждение',
						body: '".tc('Вы уверены?')."',
						confirmButton: '".tc('Да')."',
						closeButton: '".tc('Отмена')."',
						callback: function () {
							$('#itemsSelected-form input[name=\"itemsSelected[]\"]').remove();
							$('#".$id." input[name=\"itemsSelected[]\"]:checked').each(function(){
								$('#itemsSelected-form').append('<input type=\"hidden\" name=\"itemsSelected[]\" value=\"' + $(this).val() + '\" />');
							});
							$.ajax({
								type: 'post',
								url: '".$this->createUrl($url)."',
								data: $('#itemsSelected-form').serialize(),
								success: function (html) {
									$.fn.yiiGridView.update('".$id."');
								},
							});
						}
					});
					return false;
				",
			)
		);
	echo CHtml::endForm(); ?>
</div>