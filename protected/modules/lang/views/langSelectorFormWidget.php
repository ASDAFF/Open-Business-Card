<?php
/* * ********************************************************************************************
 *								Open Business Card
 *								----------------
 * 	version				:	1.5.1
 * 	copyright			:	(c) 2016 Monoray
 * 							http://monoray.net
 *							http://monoray.ru
 * 
 * 	contact us			:	http://monoray.net/contact
 *							http://monoray.ru/contact
 *
 * 	license:			:	http://open-real-estate.info/en/license
 * 							http://open-real-estate.info/ru/license
 *
 * This file is part of Open Business Card
 *
 * ********************************************************************************************* */
?>

<div class="<?php echo (demo()) ? 'language-select demo-language-select' : 'language-select';?>">
    <?php
    switch ($type) {
        case 'flags':
            foreach ($languages as $lang) {
                if ($lang['name_iso'] != $currentLang) {
                    echo CHtml::link(
                        '<img src="'  . Yii::app()->getBaseUrl() . Lang::FLAG_DIR . $lang['flag_img'] . '" title="' . $lang['name'] . '">',
                        $this->getOwner()->createLangUrl($lang['name_iso'])
                    );
                }
                ;
            }
            break;

        case 'links':
            $lastElement = end($languages);

            foreach ($languages as $lang) {
                $imgFlag = '<img src="'  . Yii::app()->getBaseUrl() . Lang::FLAG_DIR . $lang['flag_img'] . '" title="' . $lang['name'] . '" class="flag_img">';
                if ($lang['name_iso'] != $currentLang) {
                    echo CHtml::link(
                        $imgFlag . $lang['name'],
                        $this->getOwner()->createLangUrl($lang['name_iso']),
                        array('class' => 'language-select-link')
                    );
                } else {
                    echo '<span>' . $imgFlag . $lang['name'] . '</span>';
                }
                if ($lang != $lastElement) echo ' | ';
            }
            break;

        case 'dropdown':
            echo CHtml::form();
            $dropDownLangs = array();
            foreach ($languages as $lang) {
                echo CHtml::hiddenField(
                    $lang['name_iso'],
                    $this->getOwner()->createLangUrl($lang['name_iso'])
                    , array('id' => 'langurl_' . $lang['name_iso'])
                );
                $dropDownLangs[$lang['name_iso']] = $lang['name'];
            }
            echo CHtml::dropDownList('lang', $currentLang, $dropDownLangs,
                array(
                    'onclick' => ' this.form.action=$("#langurl_"+this.value).val(); this.form.submit(); return false; ',
                )
            );
            echo CHtml::endForm();

            break;
    }

    ?>
</div>