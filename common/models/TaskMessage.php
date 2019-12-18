<?php

namespace common\models;

use Yii;
use common\models\Task;
use common\models\UserProfile;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "task_message".
 *
 * @property int $id
 * @property int $task_id
 * @property int $user_id
 * @property string $message
 * @property int $is_new
 * @property int $message_to
 */
class TaskMessage extends \yii\db\ActiveRecord {

	public function behaviors() {
		return [			
			TimestampBehavior::class,			
		];
	}

	public function getOwnerData($task_id) {

		$data = TaskMessage::find()
			->with('user')
			->with('userowner')
			//->andWhere(['!=','user_id' , Yii::$app->user->identity->id])
			->andWhere(['task_id' => $task_id])
			->asArray()
			->all();
		$arUser = [];
		foreach ($data as $arr) {
			if ($arr['user_id'] != Yii::$app->user->identity->id) {

				$avatar = $arr['user']['avatar_base_url'] . $arr['user']['avatar_path'];
				if ($avatar == null) {
					$avatar = '/images/user-no-image.png';
				}
				$arUser[$arr['user_id']]['user'] = [
					"user_id" => $arr['user']['user_id'],
					"firstname" => $arr['user']['firstname'],
					"middlename" => $arr['user']['middlename'],
					"lastname" => $arr['user']['lastname'],
					"avatar" => $avatar,
					"gender" => $arr['user']['gender'],
					"location" => $arr['user']['location'],
				];
			}
			$user_id = $arr['user_id'];
			if ($arr['user_id'] == Yii::$app->user->identity->id) {
				$arr['user_id'] = $arr['message_to'];
			}
			$arUser[$arr['user_id']]['message'][] = [
				"id" => $arr['id'],
				"message" => $arr['message'],
				"user_owner_id" => $arr['user_owner_id'],
				"is_new" => $arr['is_new'],
				"user_id" => $user_id,
				"message_to" => $arr['message_to'],
				"created_at" => date('H:i:s [d-m-Y]',$arr['created_at']),
			
			];
		}
		//l($data);
		return $arUser;
	}

	/*
	 * Устанавливает все  новые сообщения для текущего задания
	 * как прочитанные is_new = 0
	 */

	public function setUserMessagesAsReaded($user_id, $task_id) {
		TaskMessage::updateAll(['is_new' => 0], ['and',
			['=', 'task_id', $task_id],
			['=', 'user_id', $user_id],
			['=', 'message_to', Yii::$app->user->identity->id],
		]);
	}

	public function getUserMessages($task_id) {

		$data = TaskMessage::find()
			->with('user')
			->with('userowner')
			->andWhere(['or',
				['user_id' => Yii::$app->user->identity->id],
				['message_to' => Yii::$app->user->identity->id]
			])
			->andWhere(['task_id' => $task_id])
			->asArray()
			->all();
		foreach ($data as $k => $arr) {
			$avatar = $arr['user']['avatar_base_url'] . $arr['user']['avatar_path'];
			if ($avatar == null) {
				$avatar = '/images/user-no-image.png';
			}
			$arr['avatar'] = $avatar;
			$arr['created_at'] = date('H:i:s [d-m-Y]',$arr['created_at']);
			$data2[$k] = $arr;
		}
		//l($data2);
		return $data2;
	}

	public function getUserowner() {
		return $this->hasOne(UserProfile::className(), ['user_id' => 'user_owner_id']);
	}

	public function getUser() {
		return $this->hasOne(UserProfile::className(), ['user_id' => 'user_id']);
	}

	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'task_message';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['task_id', 'user_id', 'message', 'is_new', 'message_to'], 'required'],
			[['task_id', 'user_id', 'is_new', 'message_to'], 'integer'],
			[['message'], 'string'],
			[['created_at'], 'default', 'value' => function () {
				return date(DATE_ISO8601);
			}],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id' => 'ID',
			'task_id' => 'Task ID',
			'user_id' => 'User ID',
			'message' => 'Message',
			'is_new' => 'Is New',
			'message_to' => 'Message To',
		];
	}

}
