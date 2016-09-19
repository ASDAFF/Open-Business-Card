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


Yii::import('zii.widgets.CMenu');
class MainMenu extends CMenu {
    public $activateItemsOuter = true;
	public $activeCssClass='current-menu-item';

    public function run() {
	   $this->renderMenu($this->items);
    }

    protected function renderMenuRecursive($items)
	{
		$count=0;
		$n=count($items);

		## TO DO - Отрефакторить
		// pre find active menu in dropdown list's
		$findActive = arraySearchInner($items, 'active', 1);
		if (!is_numeric($findActive)) { # not find "active" key
			$currentUrl = Yii::app()->getRequest()->getHostInfo().Yii::app()->request->url;
			if ($currentUrl) {

				foreach($items as $key => $value2) {
					if (array_key_exists('url', $value2) && $value2['url'] == $currentUrl) {
						$items[$key]['active'] = true;
					}
					else {
						if (array_key_exists('items', $value2)) {
							foreach($value2['items'] as $k2 => $value3) {
								if (array_key_exists('url', $value3) && $value3['url'] == $currentUrl) {
									$items[$key]['active'] = true;
								}
								else {
									if (array_key_exists('items', $value3)) {
										foreach($value3['items'] as $k3 => $value4) {
											if (array_key_exists('url', $value4) && $value4['url'] == $currentUrl) {
												$items[$key]['active'] = true;
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}

		foreach($items as $item)
		{
			$count++;
			$options=isset($item['itemOptions']) ? $item['itemOptions'] : array();
			$class=array();
			if($item['active'] && $this->activeCssClass!='')
				$class[]=$this->activeCssClass;
			if($count===1 && $this->firstItemCssClass!==null)
				$class[]=$this->firstItemCssClass;
			if($count===$n && $this->lastItemCssClass!==null)
				$class[]=$this->lastItemCssClass;
			if($this->itemCssClass!==null)
				$class[]=$this->itemCssClass;
			if($class!==array())
			{
				if(empty($options['class']))
					$options['class']=implode(' ',$class);
				else
					$options['class'].=' '.implode(' ',$class);
			}

			echo CHtml::openTag('li', $options);

			$menu=$this->renderMenuItem($item);
			if(isset($this->itemTemplate) || isset($item['template']))
			{
				$template=isset($item['template']) ? $item['template'] : $this->itemTemplate;
				echo strtr($template,array('{menu}'=>$menu));
			}
			else
				echo $menu;

			if(isset($item['items']) && count($item['items']))
			{
				//echo "\n".CHtml::openTag('div', array('class'=>'submenu', 'style' => 'display: none;'))."\n";
				echo "\n".CHtml::openTag('ul',isset($item['submenuOptions']) ? $item['submenuOptions'] : $this->submenuHtmlOptions)."\n";
				$this->renderMenuRecursive($item['items']);
				echo CHtml::closeTag('ul')."\n";
				//echo CHtml::closeTag('div')."\n";
			}

			echo CHtml::closeTag('li')."\n";
		}
	}
	
	protected function isItemActive($item,$route) {			
		if(isset($item['url']) && is_array($item['url'])) {			
			if (!strcasecmp(trim($item['url'][0],'/'),$route)) {			
				unset($item['url']['#']);
				if(count($item['url'])>1)
				{
					foreach(array_splice($item['url'],1) as $name=>$value)
					{
						if(!isset($_GET[$name]) || $_GET[$name]!=$value)
							return false;
					}
				}
				return true;
			}
									
			// for other					
			if (isset($item['url'][0]) && $route && strstr($item['url'][0], '/') && $item['url'][0] != '/site/logout' && $item['url'][0] != '/site/login') {
				$trimRoute = trim($route,'/');
				$trimUrl = trim($item['url'][0],'/');							
				# remove all after last slash and compare
				if (substr($trimRoute, 0, strrpos($trimRoute, '/') + 1) == substr($trimUrl, 0, strrpos($trimUrl, '/') + 1))
					return true;
			}
		}
		elseif (isset($item['url']) && !is_array($item['url'])) {
			$activeModule = (Yii::app()->getController()->getModule() && Yii::app()->getController()->getModule()->getId()) ? Yii::app()->getController()->getModule()->getId() : '';
			$tUrl = trim($item['url'], '/');
			$tUrlExplode = explode('/', $tUrl);
			$tUrl = (count($tUrlExplode) >  1) ? $tUrlExplode[count($tUrlExplode) - 1] : null;			

			if ($activeModule == 'infopages' && is_array(Yii::app()->getController()->getActionParams())) {
				if ($tUrl) {
					$activeMenuPage = Yii::app()->getController()->getActionParams();

					if (is_array($activeMenuPage) && array_key_exists('url', $activeMenuPage)) {
						if ($activeMenuPage['url'] == $tUrl) {
							return true;
						}
					}
				}

				return false;
			}
		}
		return false;
	}
}