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

class ParentModel extends CActiveRecord {
	public $WorkItemsSelected;

    private $_cacheRules;

    public function i18nFields(){
        return array();
    }

    public function getI18nFieldSafe(){
        $i18nFields = array_keys($this->i18nFields());
		$activeLangs = Lang::getActiveLangs();
        $i18nSafeArr = array();
        foreach($activeLangs as $lang){
            foreach($i18nFields as $field){
                $i18nSafeArr[] = $field.'_'.$lang;
            }
        }
        return implode(', ', $i18nSafeArr);
    }

    public function i18nRules($field){
        if(!isset($this->_cacheRules[$field])){
            $this->_cacheRules[$field] = self::i18nGenFields($field);
        }
        return $this->_cacheRules[$field];
    }

    public static function i18nGenFields($field){
        $activeLangs = Lang::getActiveLangs();
        $i18nRuleArr = array();
        foreach($activeLangs as $lang){
            $i18nRuleArr[] = $field.'_'.$lang;
        }
        return implode(', ', $i18nRuleArr);
    }

    public function getStrByLang($str){
   		$str .= '_'.Yii::app()->language;
		
		if (isset($this->$str))
			return $this->$str;
		
		return false;
   	}

	public function setStrByLang($str, $value){
   		$str .= '_'.Yii::app()->language;
		
		$this->$str = $value;
   	}

	protected function isEmpty($value,$trim=false)
	{
		return $value===null || $value===array() || $value==='' || $trim && is_scalar($value) && trim($value)==='';
	}


	public function isLangAttributeRequired($attribute)
	{
		foreach($this->getValidators($attribute) as $validator)
		{
			if($validator instanceof CInlineValidator && $validator->method == 'i18nRequired')
				return true;
		}
		return false;
	}

	public function i18nRequired($attribute, $params) {
		$label = $this->getAttributeLabel($attribute);

		$activeLangs = Lang::getActiveLangs(true);

        foreach($activeLangs as $lang){
			$attr = $attribute.'_'.$lang['name_iso'];

            if($lang['name_iso'] == Yii::app()->language){
                if($this->isEmpty($this->$attr,true))
                    $this->addError($attr, Yii::t('common','{label} cannot be blank for {lang}.', array('{label}'=>$label, '{lang}'=>$lang['name'])));
            }
        }
	}

	public function i18nLength($attribute, $params)
	{

		$label = $this->getAttributeLabel($attribute);

		$activeLangs = Lang::getActiveLangs(true);

        foreach($activeLangs as $lang){
			$attr = $attribute.'_'.$lang['name_iso'];

			$value=$this->$attr;

			if(function_exists('mb_strlen'))
				$length = mb_strlen($value, Yii::app()->charset);
			else
				$length = utf8_strlen($value);

			if(isset($params['min']) && $length<$params['min'])
			{
				$this->addError($attr, Yii::t('common','{label} is too short for {lang} (minimum is {min} characters).',
						array('{label}'=>$label, '{lang}'=>$lang['name'], '{min}'=>$params['min'])));
			}
			if(isset($params['max']) && $length>$params['max'])
			{
				$this->addError($attr, Yii::t('common','{label} is too long for {lang} (maximum is {max} characters).',
						array('{label}'=>$label, '{lang}'=>$lang['name'], '{max}'=>$params['max'])));
			}
			if(isset($params['is']) && $length!==$params['is'])
			{
				$this->addError($attr, Yii::t('common','{label} is of the wrong length for {lang} (should be {length} characters).',
						array('{label}'=>$label, '{lang}'=>$lang['name'], '{length}'=>$params['is'])));
			}
		}
	}

    public function getDateTimeInFormat($field = 'date_created')
    {
        $dateFormat = param('dateFormat', 'd.m.Y H:i:s');
        return date($dateFormat, strtotime($this->$field));
    }

    public function beforeSave(){
        $className = get_class($this);
        $i18attributes = CActiveRecord::model($className)->i18nFields();

        foreach($i18attributes as $attribute => $val){
            $activeLangs = Lang::getActiveLangs(true);
            $defaultValue = $this->{$attribute.'_'.Yii::app()->language};

            foreach($activeLangs as $lang){
				if (isset($lang['name_iso']) && $lang['name_iso']) {
					$attr = $attribute.'_'.$lang['name_iso'];

					if($this->isEmpty($this->$attr,true)){
						$this->$attr = $defaultValue;
					}
				}
            }
        }
		
		# чистим все поля в демке от кулхацкеров
		if (demo()) {
			$allAttributes = CActiveRecord::model($className)->getAttributes(); 
			
			if (!empty($allAttributes)) {
				$keysAttib = array_keys($allAttributes);
				
				foreach($keysAttib as $nameAttribute) {					
					$this->setAttributes(array($nameAttribute => purifyForDemo($this->{$nameAttribute})));
				}
			}
		}

        return parent::beforeSave();
    }
	
	####################################
	public function getHref(){
		return $this->getStrByLang('href');
	}
	
	public function getName(){
        return $this->getStrByLang('name');
    }
	
	public function getCost(){
        return $this->getStrByLang('cost');
    }
	
	public function getTitle(){
        return $this->getStrByLang('title');
    }
		
	public function getBody(){
        return $this->getStrByLang('body');
    }
	
	public function getDescription(){
        return $this->getStrByLang('description');
    }
	
	public function getShortPageBody(){
        return $this->getStrByLang('short_page_body');
    }
	
	public function getShortBody(){
        return $this->getStrByLang('short_body');
    }
	
	public function getPageBody() {
		return $this->getStrByLang('page_body');
	}
	
	public function getSeoTitle() {
		return $this->getStrByLang('seo_title');
	}
	
	public function getSeoKeywords() {
		return $this->getStrByLang('seo_keywords');
	}
	
	public function getSeoDescription() {
		return $this->getStrByLang('seo_description');
	}
	
	##################################
	public function getpage_body() {
		return $this->getPageBody();
	}
	
	public function getshort_page_body() {
		return $this->getShortPageBody();
	}
	
	public function getshort_body() {
		return $this->getShortBody();
	}
	
	
	public function getseo_title() {
		return $this->getSeoTitle();
	}
	
	public function getseo_keywords() {
		return $this->getSeoKeywords();
	}
	
	public function getseo_description() {
		return $this->getSeoDescription();
	}
}
