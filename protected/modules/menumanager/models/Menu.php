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

class Menu extends ParentModel{
	const LINK_NONE = 0;
	const LINK_NEW_MANUAL = 1;
	const LINK_NEW_INFO = 2;
	const MAX_LEVEL = 3;

	const MAIN_PAGE_ID = 1;
	const NEWS_ID = 2;
	const ARTICLES_ID = 3;
	const GALLERY_ID = 4;
	const CATALOG_ID = 5;
	const PRICE_ID = 6;
	const CONTACT_ID = 7;
	const REVIEWS_ID = 8;

	public $maxNumberInBranch;
	public $isSelected = false;

	private static $_menuItemsFrontend;
	private static $_menuItemsBackend;

	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	public function tableName(){
		return '{{menu}}';
	}

	public function scopes() {
		return array(
			'active'=>array(
				'condition'=>'t.active=1',
			),
			'root'=>array(
				'condition'=>'t.parentId=0',
			),
		);
	}

	public function relations(){
		return array(
			'activeChilds' => array(self::HAS_MANY, 'Menu', 'parentId', 'condition'=>'active = 1'),
			'childs' => array(self::HAS_MANY, 'Menu', 'parentId'),
			'parent' => array(self::BELONGS_TO, 'Menu', 'parentId'),
			'page' => array(self::BELONGS_TO, 'InfoPages', 'pageId'),
		);
	}

	public function rules(){
		return array(
			array('type', 'required'),
			array('title', 'i18nRequired', 'on' => 'insert'),
			array('title', 'i18nRequired', 'on' => 'special'),
			array('title', 'i18nRequired', 'on' => 'link_'.self::LINK_NONE),
			array('title, href', 'i18nRequired', 'on' => 'link_'.self::LINK_NEW_MANUAL),
			array('pageId', 'required', 'on' => 'link_'.self::LINK_NEW_INFO),
			array('number, active, pageId', 'numerical', 'integerOnly'=>true),
			array('title, href', 'i18nLength', 'max' => 255),
			array('parentId, pageId', 'length', 'max' => 11),
			array($this->getI18nFieldSafe(), 'safe'),
			array('is_blank', 'boolean'),
			array('id, parentId, number, active, is_blank', 'safe', 'on'=>'search'),
		);
	}
	
	public function i18nFields(){
		return array(
			'title' => 'varchar(255) not null',
			'href' => 'varchar(255) not null'
		);
	}

	public function attributeLabels(){
		return array(
			'title' => tc('Текст ссылки'),
			'active' => tc('Статус'),
			'type' => tc('Тип ссылки'),
			'href' => tc('Ссылка'),
			'parentId' => tc('Родительский элемент'),
			'number' => tc('Позиция'),
			'pageId' => tc('Страница'),
			'is_blank' => tc('Открывать в новом окне'),
		);
	}

	public function behaviors(){
		return array(
			'AutoTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'date_updated',
				'updateAttribute' => 'date_updated',
			),
		);
	}

	//Построение дерева страниц для администратора
	public static function buildTreePages($renew = false){
		if ($renew || !self::$_menuItemsBackend) {
			$result = self::model()->findAll(array('order'=>'t.number'));
			if(!count($result)) return array();

			foreach ($result as $item) {
				self::$_menuItemsBackend[$item->id] = array(
					'id' => $item->id,
					'parentId' => $item->parentId,
					'number' => $item->number,
					'pageId' => $item->pageId,
					'is_blank' => $item->is_blank,
					'title' => CHtml::decode($item->getTitle()),
					'href' => $item->getHref(),
					'url' => $item->getUrl(),
					'active' => $item->active,
					'type' => $item->type,
					'special' => $item->special,
				);
			}
		}

		return self::normalizeTreePages(self::$_menuItemsBackend, 0);
	}

	public static function normalizeTreePages(&$data, $depth = 0, $rootId = 0) {
		$treePages= array();
		foreach ($data as $id => $node) {
			$node['parentId'] = $node['parentId'] === null ? 0 : $node['parentId'];
			if ($node['parentId'] == $rootId) {
				unset($data[$id]);

				$children = self::normalizeTreePages($data, $depth+1, $node['id']);
				$treePages[] = array(
					'id' => $node['id'],
					'attr' => array(
						'pid' => $node['id'],
						'class' => $node['active'] ? 'jstree-checked' : '',
						'special' => $node['special'],
						'level' => $depth + 1,
					),
					'data' => $node['title'],
					'state' => count($children) ? 'open' : null,
					'children' => $children,
				);
			}
		}
		return $treePages;
	}

	public function normalize(){
		$pages=self::model()->findAll(array(
			'condition'=>'parentId=:parentId AND number>=:number AND id!=:id',
			'params'=>array(
				'id'=>$this->id,
				'parentId'=>$this->parentId,
				'number'=>$this->number,
			),
		));
		$num=$this->number;
		foreach($pages as $page){
			if($num==$page->number){
				$page->number++;
				$page->update();
			}else
				break;
			++$num;
		}
	}

	public function plainErrors(){
		$item_errors = $this->getErrors();
		$errors=array();
		foreach($item_errors as $item_error){
			$errors[]=join(', ',$item_error);
		}
		return join("<br />",$errors);
	}

	#######################################################################
	// действия с элементами
	#######################################################################

	public function setVisible($active){
		$this->active = $active;
		if(!$this->update())
			throw new CHttpException(400,$this->plainErrors());
	}

	public function rename($newTitle){
		$this->title = CHtml::encode($newTitle);

		if(!$this->update())
			throw new CHttpException(400,$this->plainErrors());
	}

	public function move($ref,$pos){
		$refPage=self::model()->findByPk($ref);
		if($refPage===null && !($ref==0 && $pos=='last'))
			throw404();

		// нельзя перемещать в "специальный" элемент (ссылка на компонент CMS)
		if ($pos == 'last' && $refPage->special == 1)
			throw new CHttpException(403, tc('Нельзя переместить в этот пункт меню'));

		switch($pos){
			case 'before':
				$this->parentId=$refPage->parentId;
				$this->number=$refPage->number;
				break;
			case 'after':
				$this->parentId=$refPage->parentId;
				$this->number=$refPage->number+1;
				break;
			case 'last':
				$this->parentId=$ref==0?0:$refPage->id;
				$this->number=self::model()->find(array(
						'select'=>'MAX(number) as maxNumberInBranch',
						'condition'=>'parentId=:parentId',
						'params'=>array(
							'parentId'=>$this->parentId
						)
					))->maxNumberInBranch+1;
				break;
			default:
				throw new CHttpException(400, tc('Действие не найдено'));
		}
		if(!$this->update())
			throw new CHttpException(400,$this->plainErrors());

		$this->normalize();
	}

	public function deleteBranch(){
		if(!$this->delete())
			throw new CHttpException(400,$this->plainErrors());

		$subPages = self::model()->findAll("parentId=".$this->id);
		foreach($subPages as $subPage)
			$subPage->deleteBranch();
	}


	public static function create($attributes){
		$item = new Menu;
		//$item->attributes = $attributes;
		$item->parentId = array_key_exists('parentId', $attributes) ? $attributes['parentId'] : null;
		$item->number = array_key_exists('number', $attributes) ? $attributes['number'] : null;
		$item->active = 0;
		$item->type = self::LINK_NONE;

		$langs = Lang::getActiveLangs();		
		foreach($langs as $lang){
			$item->{'title_'.$lang} = array_key_exists('title', $attributes) ? $attributes['title'] : null;
		}

		if(!$item->save())
			throw new CHttpException(400, $item->plainErrors());

		$item->normalize();

		return $item;
	}


	####################################################
	//Построение дерева страниц для пользователей
	public static function getMenuItems($renew = false){
		if ($renew || !self::$_menuItemsFrontend) {
			$result = self::model()->findAll(array(
				'condition'=>"active = :active",
				'params'=>array(
					'active' => 1,
				),
				'order'=>'t.number'
			));
			if(!count($result)) return array();

			foreach ($result as $item) {
				self::$_menuItemsFrontend[$item->id] = array(
					'id' => $item->id,
					'parentId' => $item->parentId,
					'number' => $item->number,
					'pageId' => $item->pageId,
					'is_blank' => $item->is_blank,
					'title' => CHtml::decode($item->getTitle()),
					'href' => $item->getHref(),
					'url' => $item->getUrl(),
					'active' => $item->active,
					'type' => $item->type,
					'special' => $item->special,
				);
			}
		}

		return self::normalizeMenuItems(self::$_menuItemsFrontend, 0);
	}

	public static function normalizeMenuItems(&$data, $depth = 0, $rootId = 0) {
		$menu= array();
		$i = 0;
		foreach ($data as $id => $node) {
			$node['parentId'] = $node['parentId'] === null ? 0 : $node['parentId'];
			if ($node['parentId'] == $rootId) {
				unset($data[$id]);

				$children = self::normalizeMenuItems($data, $depth+1, $node['id']);
				$menu[$i] = array(
					'label' => $node['title'],
					'url' => $node['url']
				);

				if ($node['is_blank'] && $node['type'] == self::LINK_NEW_MANUAL)
					$menu[$i]['linkOptions'] = array('target' => '_blank');
				if ($children)
					$menu[$i]['items'] = $children;

				$i++;
			}
		}
		return $menu;
	}


	public function getItemLevel() {
		$level = 1;
		if ($this->parentId == 0)
			return $level;

		if (isset($this->parent) && $this->parent)
			$level++;

		if (isset($this->parent->parent) && $this->parent->parent)
			$level++;

		return $level;
	}

	public function search(){
		$criteria=new CDbCriteria;

		return new CustomActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>param('adminPaginationPageSize', 20),
			),
			/*'sort'=>array(
				'defaultOrder'=>'sorter',
			)*/
		));
	}

	public function getTypes(){
		return array(
			self::LINK_NONE => tc('Ничего'),
			self::LINK_NEW_MANUAL => tc('Простая ссылка (задаётся вручную)'),
			self::LINK_NEW_INFO => tc('Информационная страница'),
		);
	}

	public function beforeSave(){
		return parent::beforeSave();
	}

	public function beforeDelete(){
		return parent::beforeDelete();
	}

	public function getUrl(){
		$url = 'javascript: void(0);'; // type self::LINK_NONE;

		if ($this->special == 1)  {
			$url = array($this->href);
		}
		else {
			if ($this->type == self::LINK_NEW_MANUAL)
				$url = $this->href;

			if ($this->type == self::LINK_NEW_INFO) {
				if (isset($this->page) && $this->page) {
					$url = $this->page->getUrl();
				}
				else {
					$url = array('/menumanager/main/view', 'id'=>$this->id);
				}
			}
		}

		return $url;
	}
}