<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
/**
 * Create user form
 */
class UserForm extends Model {

	public $username;
	public $email;
	public $user_id;
	public $password;
	public $status;
	public $site_id;
	public $UserProfile;
	public $roles;
	private $model;

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			['username', 'filter', 'filter' => 'trim'],
			['username', 'required'],
			['username', 'unique', 'targetClass' => User::class, 'filter' => function ($query) {
					if (!$this->getModel()->isNewRecord) {
						$query->andWhere(['not', ['id' => $this->getModel()->id]]);
					}
				}
			],
			['username', 'string', 'min' => 2, 'max' => 255],
			['email', 'filter', 'filter' => 'trim'],
			['email', 'required'],
			['email', 'email'],
			['email', 'unique', 'targetClass' => User::class, 'filter' => function ($query) {
					if (!$this->getModel()->isNewRecord) {
						$query->andWhere(['not', ['id' => $this->getModel()->id]]);
					}
				}],
			['password', 'required', 'on' => 'create'],
			['password', 'string', 'min' => 6],
			[['status'], 'integer'],
			[['site_id'], 'integer'],
			[['roles'], 'each',
				'rule' => ['in', 'range' => ArrayHelper::getColumn(
						Yii::$app->authManager->getRoles(), 'name'
					)]
			],
		];
	}



	/**
	 * @return User
	 */
	public function getModel() {
		if (!$this->model) {
			$this->model = new User();
		}
		return $this->model;
	}

	/**
	 * @param User $model
	 * @return mixed
	 */
	public function setModel($model) {
		$this->username = $model->username;
		$this->email = $model->email;
		$this->status = $model->status;
		//$this->site_id = $model->site_id;
		$this->user_id = $model->getId();
		$this->model = $model;
		$this->roles = ArrayHelper::getColumn(
				Yii::$app->authManager->getRolesByUser($model->getId()), 'name'
		);
		return $this->model;
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'username' => Yii::t('common', 'Имя пользователя'),
			'email' => Yii::t('common', 'Email'),
			'status' => Yii::t('common', 'Статус'),
			'password' => Yii::t('common', 'Пароль'),
			'roles' => Yii::t('common', 'Роли')
		];
	}

	/**
	 * Signs user up.
	 * @return User|null the saved model or null if saving fails
	 * @throws Exception
	 */
	public function save() {
		if ($this->validate()) {
			$model = $this->getModel();
			$isNewRecord = $model->getIsNewRecord();
			$model->username = $this->username;
			$model->email = $this->email;
			$model->status = $this->status;
			$model->site_id = Yii::$app->user->identity->site->id;
			if ($this->password) {
				$model->setPassword($this->password);
			}
			if (!$model->save()) {
				throw new Exception('Model not saved');
			}
			if ($isNewRecord) {
				$model->afterSignup();
			}
			$this->user_id = $model->getId();
			$auth = Yii::$app->authManager;
			$auth->revokeAll($model->getId());

			if ($this->roles && is_array($this->roles)) {
				foreach ($this->roles as $role) {
					$auth->assign($auth->getRole($role), $model->getId());
				}
			}

			return !$model->hasErrors();
		}
		return null;
	}

}
