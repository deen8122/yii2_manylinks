<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\swiftmailer\Message;

class EmailSend extends Model {

	const TYPE_ACTIVATION = 1;
	const TYPE_PASSWORD_RESET = 2;

	public function send($type, $data) {
		//echo Yii::$app->params['adminEmail'];
		if ($type == self::TYPE_ACTIVATION) {
			$subject = 'Письмо активации';
			$messageHtml = $this->getMessageActivation($data);
		}
		if ($type == self::TYPE_PASSWORD_RESET) {
			$subject = 'Сброс пароля';
			$messageHtml = $this->getMessagePasswordReset($data);
		}

		//l($messageHtml);
		$this->sendMail($data['email_to'], $subject, $messageHtml);
	}

	public function getMessagePasswordReset($data) {
		$message = '
		Для сброса пароля перейдите по ссылке: <a href="https://manylinks.ru' . $data['url'] . '">https://manylinks.ru' . $data['url'] . '</a>	
                ';
		$text = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/frontend/mail/template.html');
		return str_replace("#CONTENT#", $message, $text);
	}

	public function getMessageActivation($data) {
		$message = '
		Ссылка активации: <a href="https://manylinks.ru' . $data['url'] . '">активировать</a>	
                ';
		$text = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/frontend/mail/template.html');
		return str_replace("#CONTENT#", $message, $text);
	}

	public function sendMail($to, $subject, $messageHtml) {
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= 'To: ' . $to . "\r\n";
		$headers .= 'From: ManyLinks.ru <' . Yii::$app->params['adminEmail'] . ">\r\n";
		mail($to, $subject, $messageHtml, $headers);
	}

}
