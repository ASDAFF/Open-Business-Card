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


class CatalogController extends ModuleAdminController{
	public $modelName = 'Catalog';

	public function init() {
		$this->redirectTo = array('admin');
		parent::init();
	}

	public function getViewPath($checkTheme=false){
		return Yii::getPathOfAlias('application.modules.catalog.views.backend.catalog');
	}

	public function actionAdmin(){
		Yii::app()->user->setState('menu_active', 'catalog.admin');
		$this->getMaxSorter();
		$this->getMinSorter();
		//$this->with = array('catalogImages', 'catalogCategory', 'catalogSubCategory');
		parent::actionAdmin();
	}

	public function actionCreate() {
		$model = new $this->modelName;

		Yii::app()->user->setState('menu_active', 'catalog.create');

		if(isset($_POST["{$this->modelName}"])){
            $model->attributes = $_POST["{$this->modelName}"];

			if($model->validate()) {
				if($model->save(false)){
					// get files
					$images = CUploadedFile::getInstancesByName('images');
					if (isset($images) && count($images) > 0) {
						foreach ($images as $image) {
							$imageName = $image->name;
							$imageSize = $image->size;

							// check file size
							if ($imageSize > $model->fileMaxSize) {
								Yii::app()->user->setFlash('error', "Размер файла {$imageName} превышает допустимый (заданный в php.ini) размер в {$model->fileMaxSize} байт.");
								$this->redirect(array('create'));
							}

							// check file extension
							$pathInfo = pathinfo($imageName);
							$fileName = $pathInfo['filename'];
							$fileExt = strtolower($pathInfo['extension']);

							$supportExtArr = explode(',', $model->supportExt);
							$supportExtArr = array_map('trim',$supportExtArr);
							if (!in_array($fileExt, $supportExtArr)) {
								Yii::app()->user->setFlash('error', "Расширение файла {$imageName} не является допустимым.");
								$this->redirect(array('create'));
							}

							// save file and thumbs
							$fullFileName = $model->id.'_'.md5(uniqid()).'.'.$fileExt;

							$path = Yii::getPathOfAlias('webroot.uploads.catalog.'.Catalog::ORIGINAL_IMG_DIR);
							$pathMod = Yii::getPathOfAlias('webroot.uploads.catalog.'.Catalog::MODIFIED_IMG_DIR);

							$oldUMask = umask(0);
							if(!is_dir($path)){
								@mkdir($path, 0777, true);
							}
							if(!is_dir($pathMod)){
								@mkdir($pathMod, 0777, true);
							}
							umask($oldUMask);

							if(is_writable($path) && is_writable($pathMod)){
								touch($path.DIRECTORY_SEPARATOR.'index.htm');
								touch($pathMod.DIRECTORY_SEPARATOR.'index.htm');

								$image->saveAs($path.DIRECTORY_SEPARATOR.$fullFileName);
								$image = new Image($path.DIRECTORY_SEPARATOR.$fullFileName);

								$image->resize(param('maxWidthBigThumbCatalog', 500), param('maxHeightBigThumbCatalog', 375));
								$image->save();
								//$image->save($pathMod.DIRECTORY_SEPARATOR.$fullFileName);

								// save to DB
								$catalogImages = new CatalogImages();
								$catalogImages->pid = $model->id;
								$catalogImages->img = $fullFileName;
								$catalogImages->save();
							}
						}
					}

					Yii::app()->user->setFlash('success', 'Наименование успешно добавлено');
					$model->unsetAttributes();
				}
				else
					Yii::app()->user->setFlash('error', 'Наименование не добавлено. Повторите попытку позже');
			}
        }

		$this->render('create', array('model' => $model));
	}

	public function actionUpdate($id){
		$model = $this->loadModel($id);

		Yii::app()->user->setState('menu_active', 'catalog.admin');
		
		$this->performAjaxValidation($model);

		if(isset($_POST[$this->modelName])){
			$model->attributes=$_POST[$this->modelName];
			if($model->validate()) {
				if($model->save(false)){
					// get files
					$images = CUploadedFile::getInstancesByName('images');
					if (isset($images) && count($images) > 0) {
						foreach ($images as $image) {
							$imageName = $image->name;
							$imageSize = $image->size;

							// check file size
							if ($imageSize > $model->fileMaxSize) {
								Yii::app()->user->setFlash('error', "Размер файла {$imageName} превышает допустимый (заданный в php.ini) размер в {$model->fileMaxSize} байт.");
								$this->redirect(array('create'));
							}

							// check file extension
							$pathInfo = pathinfo($imageName);
							$fileName = $pathInfo['filename'];
							$fileExt = strtolower($pathInfo['extension']);

							$supportExtArr = explode(',', $model->supportExt);
							$supportExtArr = array_map('trim',$supportExtArr);
							if (!in_array($fileExt, $supportExtArr)) {
								Yii::app()->user->setFlash('error', "Расширение файла {$imageName} не является допустимым.");
								$this->redirect(array('create'));
							}

							// save file and thumbs
							$fullFileName = $model->id.'_'.md5(uniqid()).'.'.$fileExt;

							$path = Yii::getPathOfAlias('webroot.uploads.catalog.'.Catalog::ORIGINAL_IMG_DIR);
							$pathMod = Yii::getPathOfAlias('webroot.uploads.catalog.'.Catalog::MODIFIED_IMG_DIR);

							$oldUMask = umask(0);
							if(!is_dir($path)){
								@mkdir($path, 0777, true);
							}
							if(!is_dir($pathMod)){
								@mkdir($pathMod, 0777, true);
							}
							umask($oldUMask);

							if(is_writable($path) && is_writable($pathMod)) {
								touch($path.DIRECTORY_SEPARATOR.'index.htm');
								touch($pathMod.DIRECTORY_SEPARATOR.'index.htm');

								$image->saveAs($path.DIRECTORY_SEPARATOR.$fullFileName);
								$image = new Image($path.DIRECTORY_SEPARATOR.$fullFileName);

								$image->resize(param('maxWidthBigThumbCatalog', 500), param('maxHeightBigThumbCatalog', 375));
								$image->save();
								//$image->save($pathMod.DIRECTORY_SEPARATOR.$fullFileName);

								// save to DB
								$catalogImages = new CatalogImages();
								$catalogImages->pid = $model->id;
								$catalogImages->img = $fullFileName;
								$catalogImages->save();
							}
						}
					}
					Yii::app()->user->setFlash('success', 'Наименование успешно изменено');
					//$this->redirect(array('admin'));
				}
				else
					Yii::app()->user->setFlash('error', 'Наименование не изменено. Повторите попытку позже');
			}
		}

		$criteria = new CDbCriteria();
		$criteria->addInCondition('pid', array($id));
		$imagesProvider = new CustomActiveDataProvider('CatalogImages', array(
				'criteria' => $criteria,
				'pagination'=>array(
					'pageSize'=> param('adminPaginationPageSize', 20),
				),
				'sort' => array(
					'defaultOrder' => 'sorter ASC',
				),
			)
		);

		$this->render('update',
			array('model'=>$model, 'imagesProvider' => $imagesProvider,
				'minSorterImage' => $this->getMinSorterImage($model->id),
				'maxSorterImage' => $this->getMaxSorterImage($model->id)
			)
		);
	}
}