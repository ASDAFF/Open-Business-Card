<?php $this->beginContent('//layouts/main-admin', array('adminView' => 1)); ?>
<div class="wrapper page_text">
	<div class="content">
		<?php if(isset($this->breadcrumbs)):?>
			<?php $this->widget('application.components.BreadCrumbsAdmin', array(
				'links'=>$this->breadcrumbs,
			)); ?><!-- breadcrumbs -->
		<?php endif?>
		<h1 class="page_title"><?php echo $this->adminTitle; ?></h1>

		<?php
		if ($this->menu) {
			$this->widget('bootstrap.widgets.TbMenu', array(
				'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
				'stacked'=>false, // whether this is a stacked menu
				'items'=>$this->menu
			));
		}

		$this->widget('bootstrap.widgets.TbAlert');
		?>

		<div class="admin-wrapper">
		<?php
			foreach(Yii::app()->user->getFlashes() as $key => $message) {
				if ($key=='error' || $key == 'success' || $key == 'notice'){
					echo "<div class='flash-{$key}'>{$message}</div>";
				}
			}
			echo $content;
		?>
		</div>
	</div>
</div>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/habraalert.js', CClientScript::POS_END);
$this->endContent();
?>