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
class BreadCrumbsAdmin extends CBreadcrumbs {

	public $tagName='div';
	public $crumbs = array();
	public $separator = '';
	public $encodeLabel = true;

    public function run()
	{
		if(empty($this->links))
			return;

			echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";
				echo CHtml::openTag($this->tagName,array('class' => 'inside'))."\n";
					$links=array();

					if($this->homeLink===null)
						$links[]=CHtml::link('<span>'.tc('Главная страница').'</span>',Yii::app()->homeUrl,array('class' => 'first'));
					else if($this->homeLink!==false)
						$links[]=$this->homeLink;


					foreach($this->links as $label=>$url)
					{
						if(is_string($label) || is_array($url)){
							$links[]=CHtml::link('<span>'.CHtml::encode($label).'</span>', $url);
						}
						else {
							$links[]=CHtml::link('<span class="breadcrumbs-inactive">'.CHtml::encode($url).'</span>', '#', array('class' => 'last last-child'));
						}
					}
				echo implode($this->separator,$links);
			echo CHtml::closeTag($this->tagName);
		echo CHtml::closeTag($this->tagName);
	}
}
?>