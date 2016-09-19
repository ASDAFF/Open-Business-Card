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


class GalleryController extends ModuleAdminController {
	public $modelName = 'Gallery';

	public function actionUpload() {
		Yii::import("ext.EAjaxUpload.qqFileUploader");

		$gallery = new $this->modelName;
		$allowedExtensions = array("jpg","jpeg","gif","png");
		// maximum file size in bytes
		//$sizeLimit = 2 * 1024 * 1024;
		$fileMaxSize['postSize'] = toBytes(ini_get('post_max_size'));
		$fileMaxSize['uploadSize'] = toBytes(ini_get('upload_max_filesize'));
		$sizeLimit = min($fileMaxSize);

		///
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);

		$path = Yii::getPathOfAlias('webroot.uploads.gallery.'.Gallery::ORIGINAL_IMG_DIR);
		$pathMod = Yii::getPathOfAlias('webroot.uploads.gallery.'.Gallery::MODIFIED_IMG_DIR);

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

			$result = $uploader->handleUpload($path.DIRECTORY_SEPARATOR);

			if(isset($result['filename']) && $result['filename']){
				$fileSize = filesize($path.DIRECTORY_SEPARATOR.$result['filename']);
				$fileName = $result['filename'];

				$resize = new CImageHandler();

				if($resize->load($path.DIRECTORY_SEPARATOR.$fileName)){
					$resize->thumb(param('maxWidthBigThumb', 800), param('maxHeightBigThumb', 600), Gallery::KEEP_PHOTO_PROPORTIONAL)
						->save();

					// save info to  DB
					$gallery->img = $fileName;
					$gallery->save(false);
					$id = $gallery->id;

					// result echo
					$result['thumbPath'] = Yii::app()->getBaseUrl().'/'.Gallery::UPLOAD_DIR.'/'.Gallery::GALLERY_DIR.'/'.Gallery::MODIFIED_IMG_DIR.'/'.$gallery->getThumb(param('maxWidthSmallThumb', 100), param('maxHeightSmallThumb', 75));
					$result['thumbWidth'] = param('maxWidthSmallThumb', 100);
					$result['id_photo'] = $id;
				} else {
					$result['error'] = 'Wrong image type.';
					@unlink($path.DIRECTORY_SEPARATOR.$result['filename']);
				}
			}
		}
		else {
			$result['error'] = 'Access denied.';
		}

		$return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
		echo $return;
	}
}
