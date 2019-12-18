<?php

use Sitemaped\Sitemap;

return [
	'class' => 'yii\web\UrlManager',
	'enablePrettyUrl' => true,
	'showScriptName' => false,
	'rules' => [
		'' => 'site/index',
		//'<action:(rules|xxx)>' => 'page/view2',
		'/price' => 'site/price',
		'/help' => 'site/help',
		'/contacts' => 'site/contacts',
		'/privacy_policy' => 'site/privacy_policy',
		
		
		'/<slug>' => 'site/page',
		'org/<id>/add' => 'org/add',
	]
];
