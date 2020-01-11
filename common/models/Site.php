<?php

namespace common\models;

use Yii;
use common\models\User;
use common\models\SiteBlock;
use common\models\SiteBlockValue;

/**
 * This is the model class for table "site".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $active
 * @property int $deleted
 * @property string $logo
 */
class Site extends \yii\db\ActiveRecord {

	//Редакции приложения
	const SITE_VERSION_FREE = 0;
	const SITE_VERSION_EXTEND = 1;
	const SITE_VERSION_PRO = 2;
	
	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'site';
	}

	public static function getVesrionNames(){
		return [
			self::SITE_VERSION_FREE => "бесплатная версия",
			self::SITE_VERSION_EXTEND => "расширенная версия",
			self::SITE_VERSION_PRO => "полная версия",
		];
	}
	public function getVersionName(){
		$arr = Site::getVesrionNames();
		return $arr[$this->version];
	}
	public function getDataArray()
    {
        return json_decode($this->data,true);
    }
	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['name', 'code'], 'required'],
			[['description', 'data','style'], 'string'],
			[['active', 'deleted' , 'version'], 'integer'],
			[['name', 'logo', 'code'], 'string', 'max' => 255],
			[['active'], 'default', 'value' => 1],
			[['deleted', 'version'], 'default', 'value' => 0],
			[['code'], 'unique'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id' => 'ID',
			'code' => 'Название ссылки вашей страницы',
			'name' => 'Название страницы',
			'description' => 'Описание страницы',
			'active' => 'Active',
			'deleted' => 'Deleted',
			'style' => 'Стили проекта',
		];
	}

	/*
	 * Возвращает списко пользователей сайта
	 */

	public function getUsers() {
		return $this->hasMany(User::className(), ['id' => 'user_id'])
				->viaTable('user_site', ['site_id' => 'id']);
	}

	public function getBlocks() {
		return $this->hasMany(SiteBlock::className(), ['site_id' => 'id'])->orderBy(['sort' => SORT_ASC]);
		;
	}

	public function xafterSave() {
		$profile = new User();
		$this->link('user', $profile);
	}

	/**
	 * Создает блоки по умолчанию.
	 * 1 - шапка
	 * 2 - обычное текстовое поле
	 * 3 - список ссылок
	 */
	public static function createDefaultItems() {
		//Создаем сайт!
		$site = new Site();
		$site->name = Yii::$app->user->identity->email;
		$site->code = Yii::$app->user->identity->email;
		$site->save();
		//привязываем сайт с пользователем
		Yii::$app->user->identity->site_id = $site->id;
		Yii::$app->user->identity->save();
		//создаем блоки по умочанию
		$siteBlocks = new SiteBlock();
		$siteBlocks->site_id = $site->id;
		$siteBlocks->sort = 0;
		$siteBlocks->type = SiteBlock::TYPE_HEADER_PHOTO;
		$siteBlocks->save();

		//Тестовый блок
		$siteBlocks = new SiteBlock();
		$siteBlocks->site_id = $site->id;
		$siteBlocks->sort = 1;
		$siteBlocks->type = SiteBlock::TYPE_SIMPLE_TEXT;
		$siteBlocks->text = '';
		$siteBlocks->save();

		$siteBlocks = new SiteBlock();
		$siteBlocks->site_id = $site->id;
		$siteBlocks->sort = 2;
		$siteBlocks->type = SiteBlock::TYPE_LINKS;
		$siteBlocks->save();
		//Для этого блока создаем ссылки по умолчанию
		$siteBlocksValue = new SiteBlockValue();
		$siteBlocksValue->site_block_id = $siteBlocks->id;
		$siteBlocksValue->sort = 0;
		$siteBlocksValue->name = "Я в Вконтакте";
		$siteBlocksValue->value = "https://vk.com/feed";
		$siteBlocksValue->save();

		$siteBlocksValue = new SiteBlockValue();
		$siteBlocksValue->site_block_id = $siteBlocks->id;
		$siteBlocksValue->sort = 0;
		$siteBlocksValue->name = "Я в Одноклассниках";
		$siteBlocksValue->value = "https://ok.ru/feed";
		$siteBlocksValue->save();

		$siteBlocksValue = new SiteBlockValue();
		$siteBlocksValue->site_block_id = $siteBlocks->id;
		$siteBlocksValue->sort = 0;
		$siteBlocksValue->name = "Я на Facebooke";
		$siteBlocksValue->value = "https://www.facebook.com/";
		$siteBlocksValue->save();

		return $site;
	}

}
