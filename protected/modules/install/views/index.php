<h2 align="center">
	Select a language<br/>
	Выберите язык
</h2>

<?php
	foreach(Yii::app()->user->getFlashes() as $key => $message) {
		if ($key=='error' || $key == 'success' || $key == 'notice'){
			echo "<div class='flash-{$key}'>{$message}</div>";
		}
	}
?>

<br/>

<div class="span-6">&nbsp;</div>
<div class="span-6" align="center">
	<a href="<?php echo $this->createUrl('config', array('lang' => 'ru')); ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/flag_ru.png" alt="Russian / Русский" /><br/>Russian / Русский</a>
</div>
<div class="span-6" align="center">
	<a href="<?php echo $this->createUrl('config', array('lang' => 'en')); ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/flag_us.png" alt="English / Английский" /><br/>English / Английский</a>
</div>