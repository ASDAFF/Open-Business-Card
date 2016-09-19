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

class ModuleAdminController extends Controller
{
	public $layout='//layouts/admin';
	public $params = array();
	public $photoUpload = false;
	public $scenario = null;
	public $with = array();
	public $redirectTo;
	protected $_model = null;

	function init(){
		Yii::app()->bootstrap;
		Yii::app()->bootstrap->register();
		Yii::app()->params['useBootstrap'] = true;

		parent::init();
	}

	public function getViewPath($checkTheme=false){
		return Yii::getPathOfAlias('application.modules.'.$this->getModule($this->id)->getName().'.views.backend');
	}

	public function filters(){
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules(){
		return array(
			array(
				'allow',
				'expression' => '!Yii::app()->user->isGuest',
			),
			array(
				'deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionView($id){
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate(){
		$model=new $this->modelName;
		if($this->scenario){
			$model->scenario = $this->scenario;
		}
		$this->performAjaxValidation($model);

		if(isset($_POST[$this->modelName])){
			$model->attributes=$_POST[$this->modelName];
			if($model->save()){
				if($this->redirectTo){
					Yii::app()->user->setFlash('success', tc('Успешно сохранено'));
					$this->redirect($this->redirectTo);
				}else{
					$this->redirect(array('view','id'=>$model->id));
				}
			}
		}

		$this->render('create',array_merge(
				array('model'=>$model),
				$this->params
		));
	}

	public function actionUpdate($id){
		if($this->_model === null){
			$model = $this->loadModel($id);
		}
		else{
			$model = $this->_model;
		}

		$this->performAjaxValidation($model);

		if(isset($_POST[$this->modelName])){
			$model->attributes=$_POST[$this->modelName];
			if($model->save()){
				if(!(isset($_FILES['uploader']['name'][0]) && $_FILES['uploader']['name'][0])){
					if($this->redirectTo){
						Yii::app()->user->setFlash('success', tc('Успешно сохранено'));
						$this->redirect($this->redirectTo);
					}else{
						$this->redirect(array('view','id'=>$model->id));
					}
				}
				else{
					$this->photoUpload = true;
				}
			}
		}

		$this->render('update',
			array_merge(
				array('model'=>$model),
				$this->params
			)
		);
	}

	public function actionDelete($id){
		if(Yii::app()->request->isPostRequest){
			$this->loadModel($id)->delete();
			
			Yii::app()->cache->flush();
			
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionIndex(){
		$dataProvider=new CActiveDataProvider($this->modelName);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin(){
		$model = new $this->modelName('search');
		if($this->scenario){
			$model->scenario = $this->scenario;
		}
		if($this->with){
			$model = $model->with($this->with);
		}
		$model->resetScope();

		$model->unsetAttributes();  // clear any default values
		if(isset($_GET[$this->modelName])){
			$model->attributes=$_GET[$this->modelName];
		}
		$this->render('admin',
			array_merge(array('model'=>$model), $this->params)
		);
	}

	public function loadModel($id = null){
		$model = new $this->modelName;

		if($id !== null){
			if($this->with){
				$model = $model->resetScope()->with($this->with)->findByPk($id);
			}
			else{
				$model = $model->resetScope()->findByPk($id);
			}
		}
		if($this->scenario){
			$model->scenario = $this->scenario;
		}

		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModelWith($with) {
		if(isset($_GET['id'])) {
			$model = new $this->modelName;
			if($this->scenario){
				$model->scenario = $this->scenario;
			}
			if($model===null){
				throw new CHttpException(404,'The requested page does not exist.');
			}
			return $model->resetScope()->with($with)->findByPk($_GET['id']);
		}
	}

	protected function performAjaxValidation($model){
		if(isset($_POST['ajax']) && $_POST['ajax']===$this->modelName.'-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionMove(){
		if(isset($_GET['id']) && isset($_GET['direction'])){
			$direction = isset($_GET['direction']) ? $_GET['direction'] : '' ;

			$model = $this->loadModel($_GET['id']);

			if($model && ($direction == 'up' || $direction == 'down') ){
				$sorter = $model->sorter;

				if($direction == 'up'){
					if($sorter > 1){
						$sql = 'UPDATE '.$model->tableName().' SET sorter="'.$sorter.'" WHERE sorter < "'.($sorter).'" ORDER BY sorter DESC LIMIT 1';
						Yii::app()->db->createCommand($sql)->execute();
						$model->sorter--;
						$model->save(false);
					}
				}
				if($direction == 'down'){
					$maxSorter = Yii::app()->db->createCommand()
					->select('MAX(sorter) as maxSorter')
					->from($model->tableName())
					->queryScalar();

					if($sorter < $maxSorter){
						$sql = 'UPDATE '.$model->tableName().' SET sorter="'.$sorter.'" WHERE sorter > "'.($sorter).'" ORDER BY sorter ASC LIMIT 1';
						Yii::app()->db->createCommand($sql)->execute();
						$model->sorter++;
						$model->save(false);
					}
				}
			}
		}
		if(!Yii::app()->request->isAjaxRequest){
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
	}

	public function getMaxSorter(){
		$model = new $this->modelName;
		$maxSorter = Yii::app()->db->createCommand()
			->select('MAX(sorter) as maxSorter')
			->from($model->tableName())
			->queryScalar();
		$this->params['maxSorter'] = $maxSorter;
		return $maxSorter;
	}

	public function getMinSorter(){
		$model = new $this->modelName;
		$minSorter = Yii::app()->db->createCommand()
			->select('MIN(sorter) as maxSorter')
			->from($model->tableName())
			->queryScalar();
		$this->params['minSorter'] = $minSorter;
		return $minSorter;
	}

	public static function returnStatusHtml($data, $tableId, $onclick = 0, $ignore = 0){
		if($ignore){
			if(is_array($ignore)){
				if(in_array($data->id, $ignore)){
					return '';
				}
			} else {
				if($data->id == $ignore){
					return '';
				}
			}
		}

		switch ($tableId) {
			case 'images-grid':
				$url = Yii::app()->controller->createUrl("/catalog/backend/images/activate", array("id" => $data->id, 'action' => ($data->active==1?'deactivate':'activate') ));
			break;
			default:
				$url = Yii::app()->controller->createUrl("activate", array("id" => $data->id, 'action' => ($data->active==1?'deactivate':'activate') ));
				break;
		}

		$img = CHtml::image(
					Yii::app()->request->baseUrl.'/img/'.($data->active?'':'in').'active.png',
					Yii::t('common', $data->active?'Неактивно':'Активно'),
					array('title' => Yii::t('common', $data->active?'Деактивировать':'Активировать'))
				);
		$options = array();
		if($onclick){
			$options = array(
				'onclick' => 'ajaxSetStatus(this, "'.$tableId.'"); return false;',
			);
		}
		return '<div align="center">'.CHtml::link($img,$url, $options).'</div>';

	}

	public function actionActivate(){
        $field = isset($_GET['field']) ? $_GET['field'] : 'active';

		if(isset($_GET['id']) && isset($_GET['action'])){
			$action = $_GET['action'];
			$model = $this->loadModel($_GET['id']);
			if($this->scenario){
				$model->scenario = $this->scenario;
			}
			if($model){
				$model->$field = ($action == 'activate'?1:0);
				$model->update(array($field));
				
				Yii::app()->cache->flush();
			}
		}
		if(!Yii::app()->request->isAjaxRequest){
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
	}

	public function actionItemsSelected(){
        $idsSelected = Yii::app()->request->getPost('itemsSelected');

        $work = Yii::app()->request->getPost('workWithItemsSelected');

        if($idsSelected && is_array($idsSelected) && $work){
            $idsSelected = array_map('intval', $idsSelected);

            foreach($idsSelected as $id){
                $model = $this->loadModel($id);
                $model->scenario = 'changeStatus';

                if($work == 'delete'){
                    $model->delete();
                }elseif($work == 'activate') {
                    $model->active = 1;
                    $model->update('active');
                }elseif($work == 'deactivate') {
                    $model->active = 0;
                    $model->update('active');
                }
            }
        }

        if(!Yii::app()->request->isAjaxRequest){
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

	protected function rememberPage(){
		// persist page number
		$pageParam = $this->modelName . '_page';
		if (isset($_GET[$pageParam])) {
			$page = $_GET[$pageParam];
			Yii::app()->user->setState($this->id . '-page', (int) $page);
		}
		else {
			if (Yii::app()->request->isAjaxRequest) {
				$page = 1;
				Yii::app()->user->setState($this->id . '-page', (int) $page);
			}
			else {
				$page = Yii::app()->user->getState($this->id . '-page', 1);
			}

			$_GET[$pageParam] = $page;
		}
	}

	public function actionMoveImage(){
		if(isset($_GET['id']) && isset($_GET['direction'])){
			$direction = isset($_GET['direction']) ? $_GET['direction'] : '' ;

			$model = $this->loadModel($_GET['id']);

			if($model && ($direction == 'up' || $direction == 'down') ){
				$sorter = $model->sorter;

				if($direction == 'up'){
					if($sorter > 1){
						$sql = 'UPDATE '.$model->tableName().' SET sorter="'.$sorter.'" WHERE sorter < "'.($sorter).'" AND pid = "'.$model->pid.'" ORDER BY sorter DESC LIMIT 1';
						Yii::app()->db->createCommand($sql)->execute();
						$model->sorter--;
						$model->save(false);
					}
				}
				if($direction == 'down'){
					$maxSorter = Yii::app()->db->createCommand()
					->select('MAX(sorter) as maxSorter')
					->from($model->tableName())
					->where('pid = "'.$model->pid.'"')
					->queryScalar();

					if($sorter < $maxSorter){
						$sql = 'UPDATE '.$model->tableName().' SET sorter="'.$sorter.'" WHERE sorter > "'.($sorter).'" AND pid = "'.$model->pid.'" ORDER BY sorter ASC LIMIT 1';
						Yii::app()->db->createCommand($sql)->execute();
						$model->sorter++;
						$model->save(false);
					}
				}
			}
		}
		if(!Yii::app()->request->isAjaxRequest){
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
	}

	public function getMaxSorterImage($pid){
		$model = new $this->modelName;
		$maxSorter = Yii::app()->db->createCommand()
			->select('MAX(sorter) as maxSorter')
			->from('{{catalog_images}}')
			->where('pid = "'.$pid.'"')
			->queryScalar();
		$this->params['maxSorter'] = $maxSorter;
		return $maxSorter;
	}

	public function getMinSorterImage($pid){
		$model = new $this->modelName;
		$minSorter = Yii::app()->db->createCommand()
			->select('MIN(sorter) as maxSorter')
			->from('{{catalog_images}}')
			->where('pid = "'.$pid.'"')
			->queryScalar();
		$this->params['minSorter'] = $minSorter;
		return $minSorter;
	}
	
	public function actionSortItems() {
		if (isset($_POST['items']) && is_array($_POST['items']) && !empty($_POST['items'])) {
			//$thisModel = call_user_func($this->modelName, 'model');

			//$cur_items = $thisModel::model()->findAllByPk($_POST['items'], array('order'=>'sorter'));
			$cur_items = CActiveRecord::model($this->modelName)->findAllByPk($_POST['items'], array('order'=>'sorter'));
			
			for ($i = 0; $i < count($_POST['items']); $i++) {
				//$item = $thisModel::model()->findByPk($_POST['items'][$i]);

				$item = CActiveRecord::model($this->modelName)->findByPk($_POST['items'][$i]);

				if ($item->sorter != $cur_items[$i]->sorter) {
					$item->sorter = $cur_items[$i]->sorter;
					$item->save(false);
				}
			}
		}
	}
	
	public function actionAjaxEditColumn() {
		$msg = 'no_value';

		if (Yii::app()->request->isAjaxRequest) {
			$postValue = Yii::app()->request->getParam('value');
			$pk = Yii::app()->request->getParam('pk');
			$model = Yii::app()->request->getParam('model');
			$field = Yii::app()->request->getParam('field');

			if (isset($postValue) && $pk && $model && $field && class_exists($model) /*class_exists($model, false)*/) {
				$model = CActiveRecord::model($model)->findByPk($pk);

				if ($model && isset($model->$field)) {
					$model->$field = $postValue;

					if (isset($model->date_updated)) {
						$model->date_updated = new CDbExpression('NOW()');
					}

					if ($model->save(false))
						$msg = 'ok';
					else
						$msg = 'save_error';
				}
			}

			echo CJSON::encode(array('msg' => $msg, 'value' => $postValue, 'pk' => $pk));
			Yii::app()->end();
		}
	}
}