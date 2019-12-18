<?php
namespace common\modules\timereservation\assets;

use yii\web\AssetBundle;

class CalendareAsset extends AssetBundle
{

    public $js = [
        'js/calendar.js',
    ];
    
    public $css = [
        'css/calendar.css',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/../web';
        parent::init();
    }
}
