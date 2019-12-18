<?php
/**
 * Yii2 Shortcuts
 * @author Eugene Terentev <eugene@terentev.net>
 * -----
 * This file is just an example and a place where you can add your own shortcuts,
 * it doesn't pretend to be a full list of available possibilities
 * -----
 */

/**
 * @return int|string
 */
function getMyId()
{
    return Yii::$app->user->getId();
}

/**
 * @param string $view
 * @param array $params
 * @return string
 */
function render($view, $params = [])
{
    return Yii::$app->controller->render($view, $params);
}

/**
 * @param $url
 * @param int $statusCode
 * @return \yii\web\Response
 */
function redirect($url, $statusCode = 302)
{
    return Yii::$app->controller->redirect($url, $statusCode);
}

/**
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function env($key, $default = null)
{

    $value = getenv($key) ?? $_ENV[$key] ?? $_SERVER[$key];

    if ($value === false) {
        return $default;
    }

    switch (strtolower($value)) {
        case 'true':
        case '(true)':
            return true;

        case 'false':
        case '(false)':
            return false;
    }

    return $value;
}

function l($arr) {
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}

function log2file($name, $arr, $isUpdate = false) {
	ob_start();
	print_r($arr);
	if ($isUpdate) {
		$log = ob_get_contents();
		$log2 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/log/" . $name . ".txt");
		$log2 = $log . '
			--------------
			' . $log2;
		file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/log/" . $name . ".txt", $log2);
	} else {
		file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/log/" . $name . ".txt", ob_get_contents());
	}
	ob_clean();
}
