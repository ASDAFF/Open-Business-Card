<?php
Yii::import('application.modules.contactform.components.*');
$this->breadcrumbs=array(
	tc('Контакты'),
);
?>

<h2 class="page-heading"><span><?php echo tc('Контакты');?></span></h2>

<?php $this->widget('ContactformWidget', array('page' => 'contactForm')); ?>