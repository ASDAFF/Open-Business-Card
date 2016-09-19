<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Ошибка').' '.$code;
$this->breadcrumbs=array(
	tc('Ошибка').' '.$code,
);
?>

<h2 class="page-heading"><span><?php echo tc('Ошибка');?> <?php echo $code; ?></span></h2>

<div class="error">
	<?php echo CHtml::encode($message); ?>
</div>