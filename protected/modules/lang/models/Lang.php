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

class Lang extends ParentModel {
	private static $ISOlangs = array();
	private static $RFC3066langs = array('en' => 'en-US', 'ru' => 'ru-RU', 'tr' => 'tr-TR', 'uk' => 'uk-UA');

    /**
     * @var array ~ example ('ru' => 'ru', 'en' => 'en)
     */
    private static $_activeLangs;
    private static $_activeLangsTranslated;
    private static $_activeLangsFull;
    private static $_mainLang;
	private static $_adminMailLang;
	private static $_activeLangsNameISO;

    public $copy_lang_from;

	const FLAG_DIR = '/img/flags/';

    public static function getLangList() {
        $dataPath=Yii::getPathOfAlias('system.i18n.').DIRECTORY_SEPARATOR.'data';
        $dataFile = $dataPath.DIRECTORY_SEPARATOR.Yii::app()->language.'.php';
        if(is_file($dataFile)){
            $data=require($dataFile);
        }
        if(!isset($data['languages'])){
            $data=require($dataPath.DIRECTORY_SEPARATOR.'en.php');
        }
        return $data['languages'];
    }

	private static $apartmentIndexedFields = array('title', 'description', 'description_near', 'address');

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Lang the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{lang}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name_iso,' . $this->i18nRules('name'), 'required'),
            array('active, sorter', 'numerical', 'integerOnly' => true),
            array('name_iso, copy_lang_from', 'length', 'max' => 20),
            array('flag_img', 'length', 'max' => 50),
            array('name_iso', 'dubleIsoValidator'),
            array($this->i18nRules('name'), 'length', 'max' => 100),
	        array('name_rfc3066', 'safe'),
	        array('name_rfc3066', 'length', 'max' => 10),
            array('id, name_iso, active, sorter, copy_lang_from, date_updated, ' . $this->i18nRules('name'), 'safe', 'on' => 'search'),
        );
    }

    public function i18nFields() {
        return array(
            'name' => 'varchar(100) not null'
        );
    }

    public function dubleIsoValidator()
    {
		if($this->getIsNewRecord()){
			$sql = "SELECT COUNT(id) FROM " . $this->tableName() . " WHERE name_iso=:iso";
			$nameIso = $this->name_iso;
			$count = Yii::app()->db->createCommand($sql)
				->bindParam(':iso', $nameIso, PDO::PARAM_STR)
				->queryScalar();
			if ($count > 0) {
				$this->addError('name_iso', tc('Такой язык уже существует'));
			}
		}
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'name_iso' => tc('Код языка ISO 639-1'),
            'active' => tc('Активно'),
            'copy_lang_from' => tc('Скопировать данные из'),
			'flag_img' => tc('Флаг'),
			'name' => tc('Наименование'),
        );
    }


    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $maxSorter = Yii::app()->db->createCommand()
                ->select('MAX(sorter) as maxSorter')
                ->from($this->tableName())
                ->queryScalar();
            $this->sorter = $maxSorter + 1;
        }

		if ($this->scenario == 'set_default') {
            $sql = "UPDATE " . $this->tableName() . " SET main=0 WHERE id!=" . $this->id;
            Yii::app()->db->createCommand($sql)->execute();
        }
		
		// set RFC-3066
		$langCode = 'en-US';
		if (array_key_exists($this->name_iso, self::$RFC3066langs))
			$langCode = self::$RFC3066langs[$this->name_iso];

		$this->name_rfc3066 = $langCode;

        return parent::beforeSave();
    }

	public function afterSave(){
		if ($this->isNewRecord) {
			$this->addLang($this->name_iso);
			Yii::app()->cache->flush();
		}

		return parent::afterSave();
	}

	public function afterDelete() {
		Yii::app()->cache->flush();
		return parent::afterDelete();
	}

	private $_modelNameI18nArr = array(
		'Articles',
		'Catalog',
		'CatalogCategory',
		'CatalogSubCategory',
		'ConfigurationModel',
		'Gallery',
		'GalleryCategory',
		'Info',
		'InfoPages',
		'Lang',
		'Menu',
		'News',
		'Price',
		'PriceCategory',
		'TranslateMessage',
	);

	public function init() {
		self::$ISOlangs = self::getLangList();
		parent::init();
	}

    public function addLang($lang) {
        $db = Yii::app()->db;

        // pass on models with the multilanguage fields
        foreach ($this->_modelNameI18nArr as $modelName) {
            $model = new $modelName;
            $table = $model->tableName();
            $i18nFields = $model->i18nFields();

            // add the new field to the table
            foreach ($i18nFields as $field => $type) {
                $columnName = $field . '_' . $lang;
                $sql = "SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_NAME='{$table}' AND COLUMN_NAME='{$columnName}'  AND table_schema = DATABASE()";
                $fieldExist = $db->createCommand($sql)->queryScalar();
                if (!$fieldExist) {
                    $db->createCommand()->addColumn($table, $columnName, $type);

                    // copy the data from other language if it is necessary
                    if ($this->copy_lang_from) {
                        $columnFrom = $field . '_' . $this->copy_lang_from;
						if($modelName == 'SeoFriendlyUrl' && $field == 'url'){
							$sql = "UPDATE `{$table}` SET `{$columnName}`=`model_id`";
						}else{
							$sql = "UPDATE `{$table}` SET `{$columnName}`=`{$columnFrom}`";
						}
                        $db->createCommand($sql)->execute();

						# change prefix for menu url
						if ($modelName == 'Menu' && $field == 'href') {
							$sqlHrefs = 'SELECT id, href_'.$lang.' FROM '.$table.' WHERE href_'.$lang.' LIKE "{baseUrl}%"';
							$allRecords = Yii::app()->db->createCommand($sqlHrefs)->queryAll();
							if (is_array($allRecords) && count($allRecords)) {
								foreach($allRecords as $record) {
									if (is_array($record) && isset($record['id'])) {
										$value = preg_replace('/\/'.$this->copy_lang_from.'\/\b/iU', '/', $record['href_'.$lang]);
										$value = preg_replace('/{baseUrl}\/\b/i', '{baseUrl}/'.$lang.'/', $value);

										$sqlBaseUrl = 'UPDATE '.$table.' SET href_'.$lang.' = "'.$value.'" WHERE id = "'.$record['id'].'"';
										Yii::app()->db->createCommand($sqlBaseUrl)->execute();
									}
								}
							}
							unset($allRecords);
						}
                    }

					// add fulltext index
					if ($modelName == 'Apartment' && is_numeric(array_search($field, self::$apartmentIndexedFields))) {
						$addIndex = true;

						$allIndexes = $db->createCommand('SHOW INDEX FROM '.$table)->queryAll();
						if ($allIndexes) {
							$resIndex = CHtml::listData($allIndexes, 'Key_name', 'Index_type');

							if (array_key_exists($columnName, $resIndex))
								$addIndex = false;
						}

						if ($addIndex)
							$db->createCommand('ALTER TABLE '.$table.' ADD FULLTEXT ( '.$columnName.' );')->execute();
					}
                }
            }
        }
    }

    public function beforeDelete()
    {
        if ($this->name_iso == self::getDefaultLang() || $this->model()->count() <= 1) {
            return false;
        }

        $this->deleteLang($this->name_iso);
        return parent::beforeDelete();
    }

    public function deleteLang($lang)
    {
        $db = Yii::app()->db;

        foreach ($this->_modelNameI18nArr as $modelName) {
            $model = new $modelName;
            $table = $model->tableName();
            $i18nFields = $model->i18nFields();

            foreach ($i18nFields as $field => $type) {
                $columnName = $field . '_' . $lang;

                $sql = "SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_NAME='{$table}' AND COLUMN_NAME='{$columnName}' AND table_schema = DATABASE()";
                $fieldExist = $db->createCommand($sql)->queryScalar();

                if ($fieldExist) {
                    $sql = "ALTER TABLE {$table} DROP `$columnName` ";
                    $db->createCommand($sql)->execute();

					// delete fulltext index
					if ($modelName == 'Apartment' && is_numeric(array_search($field, self::$apartmentIndexedFields))) {
						$deleteIndex = false;

						$allIndexes = $db->createCommand('SHOW INDEX FROM '.$table)->queryAll();
						if ($allIndexes) {
							$resIndex = CHtml::listData($allIndexes, 'Key_name', 'Index_type');

							if (array_key_exists($columnName, $resIndex))
								$deleteIndex = true;
						}

						if ($deleteIndex)
							$db->createCommand('ALTER TABLE '.$table.' DROP INDEX ( '.$columnName.' );')->execute();
					}
                }
            }
        }
    }

    public function search() {
        $criteria = new CDbCriteria;

        $tmp = 'name_' . Yii::app()->language;
        $criteria->compare($tmp, $this->$tmp, true);
        $criteria->order = 'sorter ASC';

        return new CustomActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function getISOlangArray()
    {
        return self::$ISOlangs;
    }

    public static function getISOname($lang)
    {
        return isset(self::$ISOlangs[$lang]) ? self::$ISOlangs[$lang] : '';
    }

    public static function getISOlangForAdd()
    {
        $ret = array();
        foreach(self::$ISOlangs as $iso => $name){
            $ret[$iso] = $iso . " ($name)";
        }
        return $ret;
    }

    public static function getActiveLangs($full = false, $requery = false)
    {
		if(!obcInstall::isInstalled()){
			return array('ru', 'en');
		}

        if (!isset(self::$_activeLangs) || $requery) {
            $sql = "SELECT id, name_iso, flag_img, main, name_" . Yii::app()->language . " AS name, name_rfc3066
                    FROM {{lang}}
                    WHERE active=1
                    ORDER BY sorter ASC";
            $activeLangs = Yii::app()->db->createCommand($sql)->queryAll();

            // Загружаем данные актвных языков и определяем главный ( дефолтный )

            foreach ($activeLangs as $lang) {
                self::$_activeLangs[$lang['name_iso']] = $lang['name_iso'];
                self::$_activeLangsFull[$lang['name_iso']] = $lang;
                self::$_activeLangsTranslated[$lang['name_iso']] = $lang['name'];
				self::$_activeLangsTranslated[$lang['name_iso']] = $lang['name_rfc3066'];

                if ($lang['main']) {
                    self::$_mainLang = $lang['name_iso'];
                }
            }

        }
        return $full ? self::$_activeLangsFull : self::$_activeLangs;
    }
	
	public static function getActiveLangsNameISO($requery = false) {
		if(!obcInstall::isInstalled()){
			return array('ru', 'en');
		}
		
		if (!isset(self::$_activeLangsNameISO) || $requery) {
			$sql = "SELECT id, name_iso 
                    FROM {{lang}}
                    WHERE active = 1";
            $activeLangsNameISO = Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach ($activeLangsNameISO as $lang) {
				self::$_activeLangsNameISO[$lang['name_iso']] = $lang['name_iso'];
			}
		}
		
		return self::$_activeLangsNameISO;
	}

    public static function getAdminMenuLangs()
    {
        $admLangs = array();

        if (!isset(self::$_activeLangsFull))
            self::getActiveLangs();

        $activeLangs = self::$_activeLangsFull;

        foreach ($activeLangs as $lang) {

            if (Yii::app()->language == $lang['name_iso']) {
                $admLang = array(
                    'url' => '',
                    'linkOptions' => array('onclick' => 'return false;', 'class' => 'boldText')
                );
            } else {
                $admLang = array(
                    'url' => Yii::app()->controller->createLangUrl($lang['name_iso'])
                );
            }

            $admLang['label'] = $lang['name'];
            $admLangs[] = $admLang;
        }
        return $admLangs;
    }

    public static function getActiveLangsTranslated()
    {
        if (!isset(self::$_activeLangsTranslated)) {
            self::getActiveLangs();
        }

        return self::$_activeLangsTranslated;
    }

    public static function getDefaultLang()
    {
		if(!obcInstall::isInstalled()){
			return Yii::app()->language;
		}
        if (!isset(self::$_mainLang)) {
            $sql = "SELECT name_iso FROM {{lang}} WHERE active=1 AND main=1";
            self::$_mainLang = Yii::app()->db->createCommand($sql)->queryScalar();
        }
        return self::$_mainLang;
    }

    public static function findByCode($cod, $route, $redirect = true)
    {
        $cod = substr($cod, 0, 2);
        $activeLangs = self::getActiveLangs();

        if (empty($activeLangs[$cod])) {
            $lang = self::getDefaultLang();
        } else {
            $lang = empty($activeLangs[$cod]);
        }

        if ($redirect == true) {
            if (preg_match("/index/", $route))
                Yii::app()->controller->redirect(Yii::app()->homeUrl . $lang . '/');
            else
                Yii::app()->controller->redirect(Yii::app()->homeUrl . $lang . '/' . $route);
        } else {
            return $lang;
        }
    }

	public function getIsDefaultHtml()
    {
        if ($this->active) {
            if ($this->main == 1) {
                $onclick = 'return false;';
            } else {
                $onclick = "changeDefault(" . $this->id . ");";
            }
            return CHtml::radioButton("main", ($this->main == 1), array('onclick' => $onclick));
        }
    }

	public function setDefault()
    {
		if ($this->main || !$this->active) {
			return false;
		}

		$this->scenario = 'set_default';
		$this->main = 1;
		$this->update('main');
        return true;
    }

	public static function getDefaultLangId()
    {
        $sql = "SELECT id FROM {{lang}} WHERE main=1";
        return Yii::app()->db->createCommand($sql)->queryScalar();
    }

	public static function getFlagImgArray(){
		$d = dir(ROOT_PATH . Lang::FLAG_DIR);

		$arr = array();

		if ($d) {
			while (false !== ($name = $d->read())) {
				if ($name === '.' || $name === '..') continue;
				$code_arr = explode('.', $name);
				$code = Yii::app()->locale->getTerritory($code_arr[0]);

				$arr[$name] = $code ? $code : utf8_ucfirst($code_arr[0]);
			}
			$d->close();
		}


		asort($arr);

		return $arr;
	}

	public static function publishAssetsDD()
	{
		$assets = dirname(__FILE__) . '/../assetsDD';
		$baseUrl = Yii::app()->assetManager->publish($assets);

		if (is_dir($assets)) {
			Yii::app()->clientScript->registerCoreScript('jquery');
			Yii::app()->clientScript->registerCssFile($baseUrl . '/dd.css');
			Yii::app()->clientScript->registerScriptFile($baseUrl . '/js/jquery.dd.js', CClientScript::POS_END);
		} else {
			throw new Exception(Yii::t('common', 'Lang - Error: Couldn\'t find assetsDD folder to publish.'));
		}
	}

	public function getFlagUrl(){
		return Yii::app()->getBaseUrl().Lang::FLAG_DIR.$this->flag_img;
	}

	public function getFlagPath(){
		return Yii::app()->getBasePath().Lang::FLAG_DIR.$this->flag_img;
	}
}
