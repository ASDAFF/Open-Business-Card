<?php $this->beginContent('//layouts/main'); ?>
	<!-- MAIN -->
	<div id="main">
		<div class="wrapper clearfix">
			<?php if(isset($this->breadcrumbs)):?>
				<?php
				$this->widget('zii.widgets.CBreadcrumbs', array(
					'links'=>$this->breadcrumbs,
					'separator' => ' &#8594; ',
				));
				?>
				<div class="clearfix"></div>
				<!-- breadcrumbs -->
			<?php endif?>
			<?php
			foreach(Yii::app()->user->getFlashes() as $key => $message) {
				if ($key=='error' || $key == 'success' || $key == 'notice'){
					echo "<div class='flash-{$key}'>{$message}</div>";
				}
			}
			?>
			<?php echo $content; ?>
		</div>
	</div>
<?php $this->endContent(); ?>