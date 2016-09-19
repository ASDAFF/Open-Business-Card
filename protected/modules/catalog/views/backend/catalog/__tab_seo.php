<div class="rowold" id="menu_seo_title">
	<?php
    $this->widget('application.modules.lang.components.langFieldWidget', array(
    		'model' => $model,
    		'field' => 'seo_title',
            'type' => 'string'
    	));
    ?>
	<br/>
</div>

<div class="rowold" id="menu_seo_keywords">
	<?php
    $this->widget('application.modules.lang.components.langFieldWidget', array(
    		'model' => $model,
    		'field' => 'seo_keywords',
            'type' => 'string'
    	));
    ?>
	<br/>
</div>

<div class="rowold" id="menu_seo_description">
	<?php
    $this->widget('application.modules.lang.components.langFieldWidget', array(
    		'model' => $model,
    		'field' => 'seo_description',
            'type' => 'string'
    	));
    ?>
</div>