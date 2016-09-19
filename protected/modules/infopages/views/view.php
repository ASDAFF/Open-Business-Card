<?php $this->pageTitle .= ' - '. CHtml::encode($model->title); ?>
<?php
	$this->breadcrumbs=array(
		CHtml::encode($model->title),
	);
?>

<?php
	/*if ($model->id == InfoPages::MAIN_PAGE_ID) {
		Yii::app()->clientScript->registerLinkTag('canonical', null, Yii::app()->createAbsoluteUrl('/site/index'));
	}*/
?>

<h2 class="page-heading"><span><?php echo CHtml::encode($model->title);?></span></h2>

<?php echo $model->body; ?>
<div class="clearfix"></div>

<?php
	/*if (isset($model->menuPage) && $model->menuPage) {
		foreach ($model->menuPage as $menuPage) {
			$levelItem = $menuPage->getItemLevel();

			if ($levelItem == 2 && isset($menuPage->activeChilds) && $menuPage->activeChilds) {
				echo '<div class="block-childs-links">';
					echo '<ul>';
						foreach($menuPage->activeChilds as $childs) {
							if ($childs->getTitle()) {
								echo '<li>'.CHtml::link($childs->getTitle(), $childs->getUrl()).'</li>';
							}
						}
						echo '</ul>';
					echo '</div>';
				echo '<div class="clear">&nbsp;</div>';
			}
		}
	}*/
?>

<?php
if ($model->widget){
	echo '<div class="clear"></div><div>';
	Yii::import('application.modules.'.$model->widget.'.components.*');
	if($model->widget == 'contactform'){
		$this->widget('ContactformWidget', array('page' => 'index'));
	} else {
		$this->widget(ucfirst($model->widget).'Widget');
	}
	echo '</div>';
	echo '<div class="clearfix"></div>';
}
?>