<?php
namespace common\modules\timereservation\assets;

use yii\web\AssetBundle;

class MainAsset extends AssetBundle
{

    public $js = [
        'js/scripts.js',
    ];
    
    public $css = [
        'css/styles.css',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/../web';
        parent::init();
    }
}
