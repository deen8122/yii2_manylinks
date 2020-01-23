<?php

namespace frontend\modules\extentions\models;

use Yii;
use yii\base\Model;
use common\models\SiteVersion;

/**
 * Account form
 */
class Imager extends Model {

	public $allFilesSize = 0;
	public $uploadDir;
	public $maxDirSize = 0;
	public $files = [];
	public $errors = [];

	public function __construct($config = array()) {
		error_reporting(E_ERROR);
		$this->uploadDir = "upload/" . Yii::$app->user->identity->site_id . '/';
		$this->checkDirSize();
		$this->files = $this->getFilesInDir();
		if (!file_exists($this->uploadDir)) {
			mkdir($this->uploadDir, 0777, true);
		}
		parent::__construct($config);
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
		//return "->".$ext;
		if (in_array($ext, ['jpg', 'png', 'gif', 'jpeg']))
			return 'image';
		if ($ext == 'php')
			return 'php';
		else
			return 'file';
	}

	public function deleteByNum($index){
		$dir = opendir($this->uploadDir);
		 $i= 0;
		while ($file = readdir($dir)) {
			if ($file != '.' && $file != '..' && $file[strlen($file) - 1] != '~') {
				if($index == $i){
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
				//$ctime = filectime($path . $file) . ',' . $file;
				$list[] = [
					"fileName" => $file,
					"fileSrc" => '/' . $this->uploadDir . $file,
					'size' => filesize($this->uploadDir . '/' . $file),
					'type' => $this->getFileTypeByName($file)
				];
			}
		}
		closedir($dir);
		//krsort($list); // используя методы krsort и ksort можем влиять на порядок сортировки
		return $list;
	}

	/**
	 * @return bool
	 */
	public function save() {
		if ($this->checkDirSize($_FILES['file']['size'])) {
			if ($_FILES) {

				// if no errors and size less than 250kb
				if (!$_FILES['file']['error'] && $_FILES['file']['size'] < 5 * 1024 * 1024) {
					if (is_uploaded_file($_FILES['file']['tmp_name'])) {
						move_uploaded_file($_FILES['file']['tmp_name'], $this->uploadDir . $_FILES['file']['name']);
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

}
