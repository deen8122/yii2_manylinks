<?php

namespace common\models;

use Yii;
use common\models\User;
use common\models\SiteBlock;
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
class Site extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'site';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'active', 'deleted', 'logo'], 'required'],
            [['description'], 'string'],
            [['active', 'deleted'], 'integer'],
            [['name', 'logo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название организации',
            'description' => 'Описание организации',
            'active' => 'Active',
            'deleted' => 'Deleted',
            'logo' => 'Logo',
        ];
    }
    /*
     * Возвращает списко пользователей сайта
     */
    public function getUsers(){
	   return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->viaTable('user_site', ['site_id' => 'id']);
    }
    public function getBlocks(){
	   return $this->hasMany(SiteBlock::className(), ['site_id' => 'id'])->orderBy(['sort' => SORT_ASC]);;
    }
}
