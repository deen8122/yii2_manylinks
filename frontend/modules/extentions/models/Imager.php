<?php

namespace frontend\modules\extentions\models;

use Yii;
use yii\base\Model;
use common\models\SiteVersion;

/**
 * Imager
 */
class Imager extends Model {

	public $allFilesSize = 0;
	public $uploadDir;
	public $maxDirSize = 0;
	public $files = [];
	public $errors = [];
	private $uploadFileName = "file"; // Запрещенные расширения файлов.
	private $maxUploadFileSizeMb = 5;//Макимальный размер загружамого файла

	public function __construct($config = array()) {
		error_reporting(E_ERROR);
		$this->uploadDir = \Yii::getAlias('@webroot') ."/upload/" . Yii::$app->user->identity->site_id . '/';
		$this->checkDirSize();
		$this->files = $this->getFilesInDir();
		if (!file_exists($this->uploadDir)) {
			mkdir($this->uploadDir, 0777, true);
		}
		parent::__construct($config);
	}

	/*
	 * Функция проверяет является ли файл изображением и возвращает bool
	 * @return bool
	 */

	private function isUploadedFileImage($filePath) {
		// Создадим ресурс FileInfo
		$fi = finfo_open(FILEINFO_MIME_TYPE);
		// Получим MIME-тип
		$mime = (string) finfo_file($fi, $filePath);
		// Проверим ключевое слово image (image/jpeg, image/png и т. д.)
		if (strpos($mime, 'image') === false) {
			return false;
		}
		return true;
	}

	public function checkDirSize($fileSize = 0) {
		//получаем размеры папок от версии продукта
		$dirSizeBySite = SiteVersion::getDirSizeBySiteType();
		//сколько разрешено для текущей версии сайта
		$this->maxDirSize = $dirSizeBySite[Yii::$app->user->identity->site->version];
		//получаем  текущий размер папки
		$allFilesSize = $this->getDirSize() + $fileSize;
		if ($allFilesSize > $this->maxDirSize) {
			return false;
		}
		return true;
	}

	public function getDirSize() {
		$this->allFilesSize = 0;
		$dir = opendir($this->uploadDir);
		while ($file = readdir($dir)) {
			if ($file != '.' && $file != '..' && $file[strlen($file) - 1] != '~') {
				$this->allFilesSize += filesize($this->uploadDir . '/' . $file);
			}
		}
		return $this->allFilesSize;
	}

	public function getFileTypeByName($fileName) {
		$ext = getExtension($fileName);
		if (in_array($ext, ['jpg', 'png', 'gif', 'jpeg']))
			return 'image';
		else
			return 'file';
	}

	public function deleteByNum($index) {
		$dir = opendir($this->uploadDir);
		$i = 0;
		while ($file = readdir($dir)) {
			if ($file != '.' && $file != '..' && $file[strlen($file) - 1] != '~') {
				if ($index == $i) {
					unlink($this->uploadDir . $file);
					break;
				}
				$i++;
			}
		}
		closedir($dir);
	}

	public function getFilesInDir() {
		$dir = opendir($this->uploadDir);
		$list = array();
		while ($file = readdir($dir)) {
			if ($file != '.' && $file != '..' && $file[strlen($file) - 1] != '~') {
				$list[] = [
					"fileName" => $file,
					"fileSrc" => '/' . $this->uploadDir . $file,
					'size' => filesize($this->uploadDir . '/' . $file),
					'type' => $this->getFileTypeByName($file)
				];
			}
		}
		closedir($dir);
		return $list;
	}

	/**
	 * @return bool
	 */
	public function save() {
	if (!file_exists($this->uploadDir)) {
	mkdir($this->uploadDir, 0777, true);
			$this->errors[] = "Нет папки ".$this->uploadDir;
			return false;
		}
		if (!$this->isUploadedFileImage($_FILES[$this->uploadFileName]['tmp_name'])) {
			$this->errors[] = "Можно загружать только изображения.";
			return false;
			
		}
		if ($_FILES[$this->uploadFileName]['error']){
		
			$this->errors[] = $_FILES[$this->uploadFileName]['error'];
			return false;
		}
		if ($this->checkDirSize($_FILES[$this->uploadFileName]['size'])) {
			if ($_FILES) {
				if (!$_FILES[$this->uploadFileName]['error'] && $_FILES[$this->uploadFileName]['size'] < $this->maxUploadFileSizeMb * 1024 * 1024) {
					if (is_uploaded_file($_FILES[$this->uploadFileName]['tmp_name'])) {
						move_uploaded_file($_FILES[$this->uploadFileName]['tmp_name'], $this->uploadDir . $_FILES[$this->uploadFileName]['name']);
						return true;
					} else {
						$this->errors[] = "Ошибка загрузки файла! CODE 78";
					}
				} else {
					$this->errors[] = "Превышен размер загружаемового файла. Разрешается загружать файл не более 5 Mb";
				}
			} else {
				$this->errors[] = "Ошибка загрузки файла! CODE 84 ";
			}
		} else {
			$this->errors[] = "Превышен лимит дискового пространства";
		}
		return false;
	}
	public function uploadImageAndCrop(){
		if (!$this->isUploadedFileImage($_FILES[$this->uploadFileName]['tmp_name'])) {
			$this->errors[] = "Можно загружать только изображения.";
			return false;
			
		}
		$iWidth = $iHeight = 200; // desired image result dimensions
		$iJpgQuality = 100;
		if ($_FILES) {
			if (!$_FILES[$this->uploadFileName]['error'] && $_FILES[$this->uploadFileName]['size'] < $this->maxUploadFileSizeMb * 1024 * 1024) {
				if (is_uploaded_file($_FILES[$this->uploadFileName]['tmp_name'])) {
					// new unique filename
					$sTempFileName = 'upload/cache/' . md5(time() . rand());
					move_uploaded_file($_FILES[$this->uploadFileName]['tmp_name'], $this->uploadDir . $_FILES[$this->uploadFileName]['name']);
					$sTempFileName = $this->uploadDir . $_FILES[$this->uploadFileName]['name'];
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
						$sResultFileName = $this->uploadDir . "block-4-img" . $sExt;
						// output image to file
						imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);
						@unlink($sTempFileName);
						return $sResultFileName;
					}
				} else {
					$this->errors[] = "Ошибка загрузки файла! CODE 84 ";
				}
			} else {
				$this->errors[] = "Ошибка загрузки файла! CODE 84 ";
			}
		}
		//===================================
	}

}
