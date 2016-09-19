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


class itemPaginator extends CLinkPager {
    public $htmlOption = array();
	public $htmlOptions = array('class' => 'pager');
	public $maxButtonCount = 6;

	const CSS_SELECTED_PAGE = 'active';

	public function init(){
		//$this->cssFile = Yii::app()->request->baseUrl.'/css/pager.css';
		parent::init();
	}

	public function registerClientScript()
	{
		/*if($this->cssFile!==false)
			self::registerCssFile($this->cssFile);*/
	}

	protected function createPageButtons()
	{
		if(($pageCount=$this->getPageCount())<=1)
			return array();

		list($beginPage,$endPage)=$this->getPageRange();
		$currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
		$buttons=array();

		$buttons[]='<li class="paged">Страница '.($currentPage+1).' из '.$pageCount.'</li>';

		// internal pages
		for($i=$beginPage;$i<=$endPage;++$i)
			$buttons[]=$this->createPageButton($i+1,$i,$this->internalPageCssClass,false,$i==$currentPage);

		return $buttons;
	}

    protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		if($hidden || $selected)
			$class.=' '.($hidden ? self::CSS_HIDDEN_PAGE : self::CSS_SELECTED_PAGE);
			if ($hidden)
				return '<li class="'.$class.'">'.CHtml::link($label, 'javascript: void(0);', $this->htmlOption).'</li>';
			else
				return '<li class="'.$class.'">'.CHtml::link($label,$this->createPageUrl($page), $this->htmlOption).'</li>';
	}
}