<div class="rowold">
	<?php
    $this->widget('application.modules.lang.components.langFieldWidget', array(
    		'model' => $model,
    		'field' => 'seo_title',
            'type' => 'string'
    	));
    ?>
	<br/>
</div>

<div class="rowold">
	<?php
    $this->widget('application.modules.lang.components.langFieldWidget', array(
    		'model' => $model,
    		'field' => 'seo_keywords',
            'type' => 'string'
    	));
    ?>
	<br/>
</div>

<div class="rowold">
	<?php
    $this->widget('application.modules.lang.components.langFieldWidget', array(
    		'model' => $model,
    		'field' => 'seo_description',
            'type' => 'string'
    	));
    ?>
</div>