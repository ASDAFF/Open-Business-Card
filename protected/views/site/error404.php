<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Ошибка 404');
$this->breadcrumbs=array(
	tc('Ошибка 404'),
);
?>


<h2 class="page-heading"><span><?php echo tc('Ошибка');?> <?php echo $code; ?></span></h2>

<div class="error">
	<?php
		$content = Info::getInfo(Info::TYPE_ERROR404);
		if ($content)
			echo CHtml::decode($content);
	?>
</div>