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

class BeginRequest {
	const TIME_UPDATE = 86400;
	
	public static function startUpdating() {
		if (Yii::app()->request->getIsAjaxRequest())
			return false;

		if (!obcInstall::isInstalled())
			return false;

		$data = Yii::app()->statePersister->load();

		// Обновляем статусы 1 раз в сутки
		if (isset($data['next_check_status'])) {
			if ($data['next_check_status'] < time()) {
				$data['next_check_status'] = time() + self::TIME_UPDATE;
				Yii::app()->statePersister->save($data);

				self::clearUsersSessions();
			}
		}
		else {
			$data['next_check_status'] = time() + self::TIME_UPDATE;
			Yii::app()->statePersister->save($data);

			self::clearUsersSessions();
		}
	}

	public static function clearUsersSessions(){
		//$time = time();
		//$sql = 'DELETE FROM {{users_sessions}} WHERE expire < '.$time;

		$sql = 'DELETE FROM {{users_sessions}} WHERE expire < (UNIX_TIMESTAMP(NOW() - INTERVAL 2 DAY))';
		Yii::app()->db->createCommand($sql)->execute();
	}
}