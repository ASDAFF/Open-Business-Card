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


Yii::import('zii.widgets.CBreadcrumbs');
class BreadCrumbs extends CBreadcrumbs {

	public $tagMainName='div';
	public $htmlMainOptions=array('class'=>'breadcrumbs-user');
	public $tagName='ul';
	public $tagSeparatorName = 'li';
	public $crumbs = array();
	public $separator = '';
	public $encodeLabel = true;

    public function run()
	{
		if(empty($this->links))
			return;

			$countLinks = count($this->links);
			$zIndex = $countLinks + 1;

			echo CHtml::openTag($this->tagMainName,$this->htmlMainOptions)."\n";
					echo CHtml::openTag($this->tagName,array('class' => 'crumbs-blue' /* 'crumbs' */))."\n";
						$links=array();

						if($this->homeLink===null) {
							$links[]=
								CHtml::openTag($this->tagSeparatorName, array('class' => 'first'))."\n".
									CHtml::link('<span></span>'.tc('Главная страница') ,Yii::app()->homeUrl,array('class' => 'first', 'style' => 'z-index: '.$zIndex)).
								CHtml::closeTag($this->tagSeparatorName);
						}
						else if($this->homeLink!==false)
							$links[]=$this->homeLink;


						foreach($this->links as $label=>$url)
						{
							$zIndex--;
							if(is_string($label) || is_array($url)){
								$links[]=
									CHtml::openTag($this->tagSeparatorName)."\n".
										CHtml::link('<span></span>'.CHtml::encode($label), $url, array('style' => 'z-index: '.$zIndex)).
									CHtml::closeTag($this->tagSeparatorName);
							}
							else {
								$links[]=
									CHtml::openTag($this->tagSeparatorName)."\n".
										CHtml::link('<span></span>'.CHtml::encode($url), '#', array('class' => 'last last-child', 'style' => 'z-index: '.$zIndex)).
									CHtml::closeTag($this->tagSeparatorName);
							}
						}
					echo implode($this->separator,$links);
			echo CHtml::closeTag($this->tagName);
		echo CHtml::closeTag($this->tagMainName);
	}
}
?>