<div id="obc-ads-block">
	<div style="margin: 0 auto; width: 960px;">
	<ul>
		<li>
			<?php
			$linkTitle = Yii::t('module_install', 'Download', array(), 'messagesInFile', Yii::app()->language);
			$linkHref = (Yii::app()->language == 'ru') ? 'https://monoray.ru/products/51-open-business-card' : 'https://monoray.net/products/51-open-business-card';
			echo CHtml::link(
				'<span class="download"></span>'.$linkTitle,
				$linkHref,
				array (
					'class' => 'button green',
					'target' => '_blank',
				)
			);
			?>
		</li>
		<li>
			<?php
				echo CHtml::link(
					Yii::t('module_install', 'About product', array(), 'messagesInFile', Yii::app()->language),
					(Yii::app()->language == 'ru') ? 'https://monoray.ru/products/51-open-business-card' : 'https://monoray.net/products/51-open-business-card',
					array (
						'class' => 'button cyan',
						'target' => '_blank',
					)
				);
			?>
		</li>
		<li>
			<?php
				echo CHtml::link(
					Yii::t('module_install', 'Contact us', array(), 'messagesInFile', Yii::app()->language),
					(Yii::app()->language == 'ru') ? 'https://monoray.ru/contact' : 'https://monoray.net/contact',
					array (
						'class' => 'button cyan',
						'target' => '_blank',
					)
				);
			?>
		</li>
	</ul>
	</div>
</div>