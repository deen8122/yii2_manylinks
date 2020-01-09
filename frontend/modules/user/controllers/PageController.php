<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\Site;
use common\models\SiteBlock;
use common\models\SiteBlockValue;
use yii\web\Response;

class PageController extends Controller {

	/**
	 * @return array
	 */
	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::class,
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@']
					]
				]
			]
		];
	}

	/**
	 * @return string|\yii\web\Response
	 */
	public function actionIndex() {
		$site = Site::find()->where(['id' => Yii::$app->user->identity->site_id])->one();
		if ($site == null) {
			$site = Site::createDefaultItems();
		}
		$siteBlock = SiteBlock::find()->orderBy(['sort' => SORT_ASC])->where(['site_id' => Yii::$app->user->identity->site_id])->all();
		return $this->render('index', [
				'site' => $site,
				'siteBlock' => $siteBlock,
		]);
	}

	/*
	 * Обновление данных
	 */

	public function actionUpdate() {
		$post = Yii::$app->request->post();
		if (!Yii::$app->request->isAjax) {
			return $this->renderJSON(['code' => "error", "message" => "nAjax"]);
		}
		$model = SiteBlock::findOne(['id' => $post['id'], 'site_id' => Yii::$app->user->identity->site_id]);
		if ($model === null) {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
		if (isset($post['SBV'])) {
			foreach ($post['SBV']['name'] as $id => $name) {
				$value = $post['SBV']['value'][$id];
				$sort = $post['SBV']['sort'][$id];
				$SBV = SiteBlockValue::findOne(['id' => $id, 'site_block_id' => $model->id]);
				if ($SBV == null) {
					$SBV = new SiteBlockValue();
				}
				$SBV->site_block_id = $model->id;
				$SBV->name = $name;
				$SBV->sort = $sort;
				if(is_array($value)){
					$value = json_encode($value);
				}
				$SBV->value = $value;
				$SBV->save();
			}
		}
		$data = [];
		if (isset($post['DATA'])) {
			foreach ($post['DATA'] as $name => $value) {
				$data[$name] = $value;
			}
		}
		if (isset($post['text'])) {
			$model->text = $post['text'];
		}
		$model->data = $data;
		$model->save();
		return $this->renderJSON(['code' => "ok"]);
	}

	public function renderJSON($data) {
		Yii::$app->response->format = Response::FORMAT_JSON;
		return json_encode($data, JSON_PRETTY_PRINT);
	}

	public function actionUpdate2($id) {
		$siteBlock = \common\models\SiteBlock::find()->orderBy(['sort' => SORT_ASC])->where(['site_id' => Yii::$app->user->identity->site_id])->asArray()->all();
		$model = $this->findModel($id);
		$model->user_id = Yii::$app->user->identity->id;
		$model->categories = $_POST['category'];
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['update', 'id' => $model->id]);
		}
		return $this->render('update', [
				'model' => $model,
		]);
	}

	public function actionUpdatesort() {
		l($_POST);
		foreach ($_POST['data'] as $id => $sort) {
			if ($_POST['action'] == "blockUpdateSort") {
				$siteBlockValue = SiteBlock::findOne(['id' => $id]);
			} else {
				$siteBlockValue = SiteBlockValue::findOne(['id' => $id]);
			}

			$siteBlockValue->sort = $sort;
			$siteBlockValue->save();
		}
		return true;
	}

	public function actionUpload() {
		//l($_REQUEST);
		$uploadDir = "upload/" . Yii::$app->user->identity->site_id . '/';
		$filePath = '';
		//log2file("_REQUEST1", $_REQUEST);
		if (!file_exists($uploadDir)) {
			mkdir($uploadDir, 0777, true);
		}
		//===================================
		$iWidth = $iHeight = 200; // desired image result dimensions
		$iJpgQuality = 100;

		if ($_FILES) {

			// if no errors and size less than 250kb
			if (!$_FILES['file']['error'] && $_FILES['file']['size'] < 25000 * 1024) {
				if (is_uploaded_file($_FILES['file']['tmp_name'])) {
					// new unique filename
					$sTempFileName = 'upload/cache/' . md5(time() . rand());

					// move uploaded file into cache folder
					//move_uploaded_file($_FILES['file']['tmp_name'], $sTempFileName);
					move_uploaded_file($_FILES['file']['tmp_name'], $uploadDir . $_FILES['file']['name']);
					$sTempFileName = $uploadDir . $_FILES['file']['name'];
					// change file permission to 644
					@chmod($sTempFileName, 0644);

					if (file_exists($sTempFileName) && filesize($sTempFileName) > 0) {
						list($w_i, $h_i) = getimagesize($sTempFileName);
						$scale_w = $_REQUEST['width'] / $w_i;
						//$scale_h = 200 / $h_i;
						if ($w_i > 200) {
							$_REQUEST['x1'] /= $scale_w;
							$_REQUEST['y1'] /= $scale_w;
							$_REQUEST['w'] /= $scale_w;
							$_REQUEST['h'] /= $scale_w;
						}
						//log2file("_REQUEST2", $_REQUEST);
						//l($_REQUEST);
						$aSize = getimagesize($sTempFileName); // try to obtain image info
						if (!$aSize) {
							@unlink($sTempFileName);
							return;
						}
						// check for image type
						switch ($aSize[2]) {
							case IMAGETYPE_JPEG:
								$sExt = '.jpg';
								$vImg = @imagecreatefromjpeg($sTempFileName);
								break;

							case IMAGETYPE_PNG:
								$sExt = '.png';
								$vImg = @imagecreatefrompng($sTempFileName);
								break;
							default:
								@unlink($sTempFileName);
								return;
						}

						// create a new true color image
						$vDstImg = @imagecreatetruecolor($iWidth, $iHeight);
						// copy and resize part of an image with resampling
						imagecopyresampled(
							$vDstImg, $vImg, 0, 0, (int) $_REQUEST['x1'], (int) $_REQUEST['y1'], $iWidth, $iHeight, (int) $_REQUEST['w'], (int) $_REQUEST['h']
						);
						// define a result image filename
						$sResultFileName = $uploadDir . "block-4-img" . $sExt;
						// output image to file
						imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);
						@unlink($sTempFileName);
					}
				} else {
					l('--------------------->ERROR 2');
				}
			} else {
				l('--------------------->ERROR 1');
			}
		}
		//===================================




		/*
		  if (0 < $_FILES['file']['error']) {
		  echo 'Error: ' . $_FILES['file']['error'] . '<br>';
		  } else {
		  move_uploaded_file($_FILES['file']['tmp_name'], $uploadDir . $_FILES['file']['name']);
		  $filePath = $_SERVER['DOCUMENT_ROOT'] . $uploadDir . $_FILES['file']['name'];
		  }
		  //$this->pictureFile->saveAs('../files/upload/' . $this->pictureFile->baseName . '.' . $this->pictureFile->extension);

		 */
		return $this->renderJSON(['code' => 'ok', "file" => $sResultFileName]);
	}

	/**
	 * Создаем новый блок!
	 * @return $id
	 */
	public function actionCreateblock() {
		$sb = new SiteBlock();
		$sb->site_id = Yii::$app->user->identity->site_id;
		$sb->type = (int) $_POST['type'];
		if ($sb->save()) {
			return $this->renderJSON(['code' => "ok", "id" => $sb->id]);
		} else {
			return $this->renderJSON(['code' => "error", "message" => implode(",", $sb->errors['model'])]);
		}
	}

	/**
	 * Создаем новый блок!
	 * @return $id
	 */
	public function actionSbvcreate() {
		$SBV = new SiteBlockValue();
		//$sb->site_id = Yii::$app->user->identity->site_id;
		$SBV->site_block_id = $_POST['block_id'];
		$SBV->sort = $_POST['sort'];
		if ($SBV->save()) {
			return $this->renderJSON(['code' => "ok", "id" => $SBV->id]);
		} else {
			return $this->renderJSON(['code' => "error", "message" => implode(",", $SBV->errors['model'])]);
		}
	}

	//createblock
	public function actionSbvdelete() {
		if ($_POST['id'] > 0) {
			$siteBlock = SiteBlock::findOne(['id' => $_POST['sb_id'], 'site_id' => Yii::$app->user->identity->site_id]);
			$siteBlockValue = SiteBlockValue::findOne(['id' => $_POST['id'], 'site_block_id' => $siteBlock->id]);
			$siteBlockValue->delete();
		}
		return true;
	}

	/*
	 * Удаление SiteBlock
	 */

	public function actionBlockremove() {
		if ($_POST['id'] > 0) {
			$siteBlock = SiteBlock::findOne(['id' => $_POST['id'], 'site_id' => Yii::$app->user->identity->site_id]);
			$siteBlock->delete();
			return json_encode(["code" => "ok", "id" => $_POST['id']]);
		}
	}

	/*
	 * Удаление SiteBlock
	 */

	public function actionBlockactivate() {
		$post = Yii::$app->request->post();
		if ($post['id'] > 0) {
			if ($post['type'] == "SiteBlockValue") {
				$siteBlock = SiteBlockValue::findOne(['id' => $post['id']]);
			} else {
				$siteBlock = SiteBlock::findOne(['id' => $post['id'], 'site_id' => Yii::$app->user->identity->site_id]);
			}
			$siteBlock->setActive($post['status'] > 0 ? true : false);
			return json_encode(["code" => "ok", "id" => $post['id'], 'status' => $siteBlock->status]);
		}
	}

	protected function findModel($id) {
		if (($model = Task::findOne(['id' => $id, 'user_id' => Yii::$app->user->identity->id])) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
		//  throw new NotFoundHttpException('The requested page does not exist.');
	}

}
