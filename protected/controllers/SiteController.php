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

class SiteController extends Controller {

	/**
	 * Declares class-based actions.
	 */
	public function actions() {
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha' => array(
				'class' => 'MathCCaptchaAction',
				'backColor' => 0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page' => array(
				'class' => 'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex() {
		$model = Menu::model()->findByPk(InfoPages::MAIN_PAGE_ID);
		$this->getHeaders($model);

		$messAfterInstall = Yii::app()->request->getParam('success');
		if ($messAfterInstall && $messAfterInstall == 'yes')
			Yii::app()->user->setFlash('success', tc('Настройки базы данных успешно сохранены, база данных проинициализирована.'));
		elseif ($messAfterInstall && $messAfterInstall == 'no')
			Yii::app()->user->setFlash('notice', "Не удалось создать файл ".ALREADY_INSTALL_FILE.", для избежания повторной установки, пожалуйста, создайте его самостоятельно или отключите модуль 'Install' сразу после установки.");

		$this->render('index', array('model' => $model));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError() {
		$this->layout='//layouts/user';

		if ($error = Yii::app()->errorHandler->error) {
			if (Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else {
				if ($error['code'] && $error['code'] == 404) {
					$this->render('error404', $error);
				}
				else {
					$this->render('error', $error);
				}
			}
		}
	}
	/**
	 * Displays the login page
	 */
	public function actionLogin() {
		$this->layout='//layouts/user';

		$model = new LoginForm;

		if (Yii::app()->user->getState('attempts-login') >= LoginForm::ATTEMPTSLOGIN) {
			$model->scenario = 'withCaptcha';
		}
		
		// if it is ajax validation request
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if (isset($_POST['LoginForm'])) {
			$model->attributes = $_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if ($model->validate() && $model->login()) {
				//$this->redirect(Yii::app()->user->returnUrl);
				$this->redirect(array('/admin/backend/main/index'));
				Yii::app()->end();
			}
			else {
				Yii::app()->user->setState('attempts-login', Yii::app()->user->getState('attempts-login', 0) + 1);

				if (Yii::app()->user->getState('attempts-login') >= LoginForm::ATTEMPTSLOGIN) {
					$model->scenario = 'withCaptcha';
				}
			}
		}
		// display the login form
		$this->render('login', array('model' => $model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout() {
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionSearch() {
		if (!param('useSiteSearch', 0))
			throw404();

		$this->layout='//layouts/user';

		$word = explode(" ", cleanPostData(Yii::app()->request->getParam('term')));
		$wordsArr = cleanArrayToSearch($word, $this->maxLengthSearch, $this->minLengthSearch);
		$words = '';

		if (count($wordsArr)) {
			$searchRes = array();
			$words = implode(' ', $wordsArr);

			$criteriaMain = new CDbCriteria();
			$criteriaMain->order = 'relevance DESC';

			// articles
			$criteria = new CDbCriteria();
			$tmp = array();
			$lang = Yii::app()->language;
			
			$tmp[] = 'id, title_'.$lang.', page_body_'.$lang;
			$tmp[] = "MATCH (title_{$lang}, page_body_{$lang}, short_page_body_{$lang}) AGAINST ('*{$words}*' IN BOOLEAN MODE) as relevance";
			$criteria->select = $tmp;
			$criteria->addCondition("MATCH (title_{$lang}, page_body_{$lang}, short_page_body_{$lang}) AGAINST ('*{$words}*' IN BOOLEAN MODE)");
			$criteria->mergeWith($criteriaMain);
			$articles = Articles::model()->findAll($criteria);


			// catalog
			$criteria = new CDbCriteria();
			$tmp = array();
			$tmp[] = 'id, title_'.$lang.', description_'.$lang;
			$tmp[] = "MATCH (title_{$lang}, description_{$lang}) AGAINST ('*{$words}*' IN BOOLEAN MODE) as relevance";
			$criteria->select = $tmp;
			$criteria->addCondition("MATCH (title_{$lang}, description_{$lang}) AGAINST ('*{$words}*' IN BOOLEAN MODE)");
			$criteria->mergeWith($criteriaMain);
			$catalog = Catalog::model()->findAll($criteria);

			// info
			$criteria = new CDbCriteria();
			$tmp = array();
			$tmp[] = 'id, title_'.$lang.', body_'.$lang;
			$tmp[] = "MATCH (title_{$lang}, body_{$lang}) AGAINST ('*{$words}*' IN BOOLEAN MODE) as relevance";
			$criteria->select = $tmp;
			$criteria->addCondition("MATCH (title_{$lang}, body_{$lang}) AGAINST ('*{$words}*' IN BOOLEAN MODE) AND id <> ".Menu::MAIN_PAGE_ID."");
			$criteria->mergeWith($criteriaMain);
			$infopages = InfoPages::model()->findAll($criteria);

			// news
			$criteria = new CDbCriteria();
			$tmp = array();
			$tmp[] = 'id, title_'.$lang.', body_'.$lang.', short_body_'.$lang;
			$tmp[] = "MATCH (title_{$lang}, body_{$lang}, short_body_{$lang}) AGAINST ('*{$words}*' IN BOOLEAN MODE) as relevance";
			$criteria->select = $tmp;
			$criteria->addCondition("MATCH (title_{$lang}, body_{$lang}, short_body_{$lang}) AGAINST ('*{$words}*' IN BOOLEAN MODE)");
			$criteria->mergeWith($criteriaMain);
			$news = News::model()->findAll($criteria);

			// price
			$criteria = new CDbCriteria();
			$tmp = array();
			$tmp[] = 'id, name_'.$lang;
			$tmp[] = "MATCH (name_{$lang}) AGAINST ('*{$words}*' IN BOOLEAN MODE) as relevance";
			$criteria->select = $tmp;
			$criteria->addCondition("MATCH (name_{$lang}) AGAINST ('*{$words}*' IN BOOLEAN MODE)");
			$criteria->mergeWith($criteriaMain);
			$price = Price::model()->findAll($criteria);

			if ($articles) {
				foreach($articles as $article) {
					$searchRes[] = array(
						'id' => $article->id,
						'url' => $article->getUrl(),
						'title' => $article->title,
						'body' => highlightContent($wordsArr, $article->page_body),
					);
				}
			}
			if ($catalog) {
				foreach($catalog as $cat) {
					$searchRes[] = array(
						'id' => $cat->id,
						'url' => $cat->getUrl(),
						'title' => $cat->title,
						'body' => highlightContent($wordsArr, $cat->description),
					);
				}
			}
			if ($infopages) {
				foreach($infopages as $page) {
					$searchRes[] = array(
						'id' => $page->id,
						'url' => $page->getUrl(),
						'title' => $page->title,
						'body' => highlightContent($wordsArr, $page->body),
					);
				}
			}
			if ($news) {
				foreach($news as $n) {
					$searchRes[] = array(
						'id' => $n->id,
						'url' => $n->getUrl(),
						'title' => $n->title,
						'body' => highlightContent($wordsArr, $n->body),
					);
				}
			}
			if ($price) {
				foreach($price as $p) {
					$searchRes[] = array(
						'id' => $p->id,
						'url' => Yii::app()->createAbsoluteUrl('/price/main/index'),
						'title' => $p->name,
						'body' => highlightContent($wordsArr, $p->name),
					);
				}
			}
			
			$itemsProvider = new CArrayDataProvider($searchRes, array(
				'pagination' => array(
					'pageSize' => 8,
				)
			));
			$this->render('search', compact('itemsProvider', 'words', 'wordsArr'));
		}
		else {
			throw404();
		}
	}

	public function actionUploadImage() {
		$allowExtension = array('png','jpg','gif','jpeg');

		if(Yii::app()->user->getState("isAdmin")){
			$type = Yii::app()->request->getQuery('type');
			Controller::disableProfiler(); // yii-debug-toolbar disabler

			if($type == 'imageUpload'){
				if (!empty($_FILES['upload']['name']) && !Yii::app()->user->isGuest) {
					//$dir = Yii::getPathOfAlias('webroot.upload') . '/' . Yii::app()->user->id . '/';
					$dir = Yii::getPathOfAlias('webroot.uploads.editor') . '/';
					if (!is_dir($dir))
						@mkdir($dir, '0777', true);

					$file = CUploadedFile::getInstanceByName('upload');
					if ($file) {
						$newName = md5(time()) . '.' . $file->extensionName;

						$error = '';
						$callback = $_GET['CKEditorFuncNum'];

						if (in_array($file->extensionName, $allowExtension)) {
							if ($file->saveAs($dir . $newName)) {
								$httpPath = Yii::app()->getBaseUrl(true).'/uploads/editor/' . $newName;
							}
							else {
								$error = 'Some error occured please try again later';
								$httpPath = '';
							}
						}
						else {
							$error = 'The file is not the image';
							$httpPath = '';
						}

						echo "<script type=\"text/javascript\">window.parent.CKEDITOR.tools.callFunction(".$callback.",  \"".$httpPath."\", \"".$error."\" );</script>";
					}
				}
			}
		}
	}
}