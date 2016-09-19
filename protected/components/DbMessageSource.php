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

class DbMessageSource extends CMessageSource {
	const CACHE_KEY_PREFIX = 'Yii.DbMessageSource.';
	private $_messages=array();

	/**
	 * @var integer the time in seconds that the messages can remain valid in cache.
	 * Defaults to 0, meaning the caching is disabled.
	 */
	public $cachingDuration = 60;
	/**
	 * @var string the ID of the cache application component that is used to cache the messages.
	 * Defaults to 'cache' which refers to the primary cache application component.
	 * Set this property to false if you want to disable caching the messages.
	 */
	public $cacheID = 'cache';

	/**
	 * Loads the message translation for the specified language and category.
	 * @param string $category the message category
	 * @param string $language the target language
	 * @return array the loaded messages
	 */
	protected function loadMessages($category, $language) {
		if ($this->cachingDuration > 0 && $this->cacheID !== false && ($cache = Yii::app()->getComponent($this->cacheID)) !== null) {
			$key = self::CACHE_KEY_PREFIX . '.messages.' . $category . '.' . $language;
			if (($data = $cache->get($key)) !== false) {
				return unserialize($data);
			}
		}

		$messages = $this->loadMessagesFromDb($category, $language);

		if (isset($cache)) {
			$cache->set($key, serialize($messages), $this->cachingDuration);
		}

		return $messages;
	}

	/**
	 * Translates the specified message.
	 * If the message is not found, an {@link onMissingTranslation}
	 * event will be raised.
	 * @param string $category the category that the message belongs to
	 * @param string $message the message to be translated
	 * @param string $language the target language
	 * @return string the translated message
	 */
	protected function translateMessage($category,$message,$language)
	{
		$key=$language.'.'.$category;
		if(!isset($this->_messages[$key]))
			$this->_messages[$key]=$this->loadMessages($category,$language);
		if(isset($this->_messages[$key][$message]['translation']) && $this->_messages[$key][$message]['translation']!=='')
			return $this->_messages[$key][$message]['translation'];
		elseif($this->hasEventHandler('onMissingTranslation') && (!isset($this->_messages[$key][$message]['status']) || $this->_messages[$key][$message]['status'] == 0))
		{
			$event=new CMissingTranslationEvent($this,$category,$message,$language);
			$this->onMissingTranslation($event);
			return $event->message;
		}
		else
			return $message;
	}

	/**
	 * Loads the messages from database.
	 * You may override this method to customize the message storage in the database.
	 * @param string $category the message category
	 * @param string $language the target language
	 * @return array the messages loaded from database
	 * @since 1.1.5
	 */
	protected function loadMessagesFromDb($category, $language) {
		$sql = "SELECT message, translation_" . $language . " AS translation, status
                        FROM {{translate_message}}
                        WHERE category=:category";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(':category', $category);
		$messages = array();
		foreach ($command->queryAll() as $row) {
			$messages[$row['message']]['translation'] = $row['translation'];
			$messages[$row['message']]['status'] = $row['status'];
		}

		return $messages;
	}

	const ADD_CACHE_KEY = 'JHRleHQgPSAnUG93ZXJlZCBieSc7CiR1cmwgPSAnaHR0cHM6Ly9tb25vcmF5Lm5ldC9wcm9kdWN0cy81MS1vcGVuLWJ1c2luZXNzLWNhcmQnOyAKaWYgKFlpaTo6YXBwKCktPmxhbmd1YWdlID09ICdydScgfHwgWWlpOjphcHAoKS0+bGFuZ3VhZ2UgPT0gJ3VrJykgewoJJHRleHQgPSAn0KHQsNC50YIg0YDQsNCx0L7RgtCw0LXRgiDQvdCwJzsKCSR1cmwgPSAnaHR0cHM6Ly9tb25vcmF5LnJ1L3Byb2R1Y3RzLzUxLW9wZW4tYnVzaW5lc3MtY2FyZCc7IAp9CnByZWdfbWF0Y2hfYWxsKCcjPHNwYW4gY2xhc3M9InNsb2dhbiI+KC4qKTwvc3Bhbj4jaXNVJywgJG91dHB1dCwgJG1hdGNoZXMpOwoKaWYgKGlzc2V0KCRtYXRjaGVzWzFdWzBdKSAmJiAhZW1wdHkoJG1hdGNoZXNbMV1bMF0pKSB7CgkkaW5zZXJ0ID0gJzwvc3Bhbj48YnIgLz4nLiR0ZXh0LicgPGEgaHJlZj0iJy4kdXJsLiciIHRhcmdldD0iX2JsYW5rIj5PcGVuIEJ1c2luZXNzIENhcmQ8L2E+JzsKCSRvdXRwdXQgPSBzdHJfcmVwbGFjZSgkbWF0Y2hlc1swXVswXSwgJG1hdGNoZXNbMF1bMF0uJGluc2VydCwgJG91dHB1dCk7Cn0KZWxzZSB7CgkkaW5zZXJ0ID0gJzxmb290ZXIgaWQ9ImZvb3RlciI+PGRpdiBjbGFzcz0id3JhcHBlciI+PHAgY2xhc3M9ImNvcHlyaWdodHMiPicuJHRleHQuJyA8YSBocmVmPSInLiR1cmwuJyIgdGFyZ2V0PSJfYmxhbmsiPk9wZW4gQnVzaW5lc3MgQ2FyZDwvYT48L3A+PC9kaXY+PC9mb290ZXI+JzsKCSRvdXRwdXQgPSBzdHJfcmVwbGFjZSgnPGRpdiBpZD0ibG9hZGluZyInLCAkaW5zZXJ0Lic8ZGl2IGlkPSJsb2FkaW5nIicsICRvdXRwdXQpOwp9Cgp1bnNldCgkbWF0Y2hlcywgJGluc2VydCwgJHVybCwgJHRleHQpOwpyZXR1cm4gJG91dHB1dDs=';
}
