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


class Notifier {
	public function contactForm(ContactForm $contactForm){
		$oldLang = Yii::app()->language;
		Yii::app()->setLanguage(Lang::getDefaultLang());
		
		$subj = tc('New message (contact form)');
		$body = Yii::app()->controller->renderPartial('//../components/Notifier/messages/_contactForm',
			array(
				'form' => $contactForm,
			), true);
		
		Yii::app()->setLanguage($oldLang);
		return $this->_sendEmail(param('adminEmail'), $body, $subj);
	}

	public function reviewsForm(Reviews $reviewsForm){	
		$oldLang = Yii::app()->language;
		Yii::app()->setLanguage(Lang::getDefaultLang());
		
		$subj = tc('The new review was added');
		$body = Yii::app()->controller->renderPartial('//../components/Notifier/messages/_reviewsForm',
			array(
				'form' => $reviewsForm,
			), true);
		
		Yii::app()->setLanguage($oldLang);
		return $this->_sendEmail(param('adminEmail'), $body, $subj);
	}


	private function _sendEmail($to, $message, $subject = '') {
		Yii::import('application.extensions.YiiMailer.YiiMailer');
		$mailer = $this->_setSettings(new YiiMailer());
		
		$mailer->setFrom(param('adminEmailFrom'), param('mailNameFrom', 'Administrator'));
		$mailer->setTo($to);

		//$mailer->setAddresses('to', $to);
		
		//$mailer->setSubject = $subject;
		//$mailer->setBody = $message;
		
		$mailer->Subject = $subject;
		$mailer->Body = $message;
		
		if ($mailer->Send()){
			return true;
		} else {
			return false;
			//throw new CHttpException(503, 'Message not send.  ErrorInfo: ' . $mailer->getError());
		}
	}
	
	public function _setSettings(YiiMailer $mailer) {
		if (param('mailSMTP', 0)) {
			$mailer->setSmtp(
				param('mailHost', 'localhost'), 
				param('mailPort', 25), 
				param('mailSMTPSecure'), 
				true, 
				param('mailUser'), 
				param('mailPass')
			);
		}
		$mailer->CharSet = 'UTF-8';
		$mailer->IsHTML(true);
		
		//$mailer->IsMail();
		//$mailer->IsSendMail();
		
		return $mailer;
	}
}
