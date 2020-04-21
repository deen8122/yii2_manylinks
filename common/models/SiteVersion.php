<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\Site;
use common\models\SiteBlock;

/*
 * Клас для работы с версиями приложения
 */

class SiteVersion extends Model {

	public static function getDirSizeBySiteType() {
		return [
			Site::SITE_VERSION_FREE => 2 * 1024 * 1024, //2 Mb Бесплатно
			Site::SITE_VERSION_EXTEND => 10 * 1024 * 1024, //10 Mb
			Site::SITE_VERSION_PRO => 20 * 1024 * 1024, //20 Mb
		];
	}

	public static function check($type, &$errorText) {
		$version = Yii::$app->user->identity->site->version;
		/*
		 * Бесплтаная версия продукта
		 * только три обьекта
		 */
		$errorText = 'Версия вашего продукта не позволяет добавлять новые значения';
		if ($version == Site::SITE_VERSION_FREE) {
			/*
			 * Разрешается только три обьекта SiteBlock
			 */
			$count = SiteBlock::find()->where(['site_id' => Yii::$app->user->identity->site_id])->count();
			//если выбрана добавить блок TYPE_HEADER_PHOTO и этот блок уже ранее добавлен.
			if ($type == SiteBlock::TYPE_HEADER_PHOTO) {
				$count = SiteBlock::find()->where(['site_id' => Yii::$app->user->identity->site_id, 'type' => SiteBlock::TYPE_HEADER_PHOTO])->count();
				if ($count > 0) {
					$errorText = 'Этот блок уже добавлен!';
					return false;
				}
			}
			//l($count);
			if ($count >= 3) {
				$errorText = 'Версия вашего продукта не позволяет добавлять более трех блоков';
				return false;
			}
			//разрешены только три блока
			if ($type == SiteBlock::TYPE_HEADER_PHOTO || $type == SiteBlock::TYPE_SIMPLE_TEXT || $type == SiteBlock::TYPE_HTML_TEXT|| $type == SiteBlock::TYPE_LINKS) {
				return true;
			} else {
				$errorText = 'Версия вашего продукта  позволяет добавлять блоки: текстовый, ссылки, шапка';
				return false;
			}
		}

		/*
		 * Расширенная версия.
		 * 6 блоков доступны.
		 * Возможно будет меняться
		 */
		if ($version == Site::SITE_VERSION_EXTEND) {
			/*
			 * Разрешается только шесть обьекта SiteBlock
			 */
			$count = SiteBlock::find()->where(['site_id' => Yii::$app->user->identity->site_id])->count();
			//l($count);
			if ($count >= 6) {
				return false;
			}
		}
		/*
		 * Расширенная версия.
		 * 6 блоков доступны.
		 * Возможно будет меняться
		 */
		if ($version == Site::SITE_VERSION_PRO) {
			$count = SiteBlock::find()->where(['site_id' => Yii::$app->user->identity->site_id])->count();
			if ($count >= 12) {
				return false;
			}
		}

		//l($version);
		return true;
	}

}
