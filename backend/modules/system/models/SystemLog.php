<?php

namespace backend\modules\system\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "system_log".
 *
 * @property integer $id
 * @property integer $level
 * @property string  $category
 * @property integer $log_time
 * @property string  $prefix
 * @property integer $message
 */
class SystemLog extends ActiveRecord
{
    const CATEGORY_NOTIFICATION = 'notification';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%system_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'log_time', 'message'], 'integer'],
            [['log_time'], 'required'],
            [['prefix'], 'string'],
            [['category'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'level' => Yii::t('backend', 'Уровень'),
            'category' => Yii::t('backend', 'Категория'),
            'log_time' => Yii::t('backend', 'Время события'),
            'prefix' => Yii::t('backend', 'Префикс'),
            'message' => Yii::t('backend', 'Сообщение'),
        ];
    }
}
