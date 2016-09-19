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
    		'field' => 'page_body',
            'type' => 'text-editor'
    	));
    ?>
	<br/>
</div>

<div class="rowold">
	<?php
    $this->widget('application.modules.lang.components.langFieldWidget', array(
    		'model' => $model,
    		'field' => 'short_page_body',
            'type' => 'text-editor'
    	));
    ?>
</div>