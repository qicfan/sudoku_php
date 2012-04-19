<?php
// session超时时间设定
session_cache_expire(4*60); // 页面存活期 分
ini_set('session.gc-maxlifetime', 24*60*60); // 过期回收时间，秒
return array(
	'basePath'=> BASEPATH,
	'name'=>'sudoku',
	'charset'=>'utf-8',
	//默认控制器
	'defaultController'=>'sudoku',
	//设置时区及语言
	'timeZone'=>'Asia/Shanghai',
	'language'=>'zh_cn',
	//预加载log组件
	'preload'=>array('sessionCache'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.QQueue.*'
	),

	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'zeroq.me',
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	),

	// application components
	'components'=>array(
		//路由处理组件
		'urlManager'=>array(
			'urlFormat'=>'path',
			'caseSensitive'=>false,		// 是否区分大小写
			'showScriptName'=>false,	// 显示脚本文件名
			'useStrictParsing'=>false,	// 404时显示完整路径，默认为false
			'appendParams'=>true,
			'rules'=>array(
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		// 主库
		'mdb'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=localhost;dbname=test',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'qi101585',
			'charset' => 'utf8',
			'enableProfiling'=>true,
			'schemaCachingDuration'=>3600,
		),
		// 从库
		'sdb'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=localhost;dbname=test',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'qi101585',
			'charset' => 'utf8',
			'enableProfiling'=>true,
			'schemaCachingDuration'=>3600,
		),

		//session组件 多个二级域名访问时需要
		'session'=>array(
			'cookieParams' => array('domain' => '.'.implode('.',array_slice(explode(".",strpos($_SERVER['HTTP_HOST'],':') ? substr($_SERVER['HTTP_HOST'],0,strpos($_SERVER['HTTP_HOST'],':')) : $_SERVER['HTTP_HOST']),-2,2)),),
		),
		// session集中存放memcache
		'sessionCache' => array(
			'class'=>'ext.session.SessionCache',
			'servers'=>array(
				array('host'=>'127.0.0.1','port'=>11211),
			),
		),

		// 远程cache
		'cache'=>array(
			'class'=>'ext.cache.ZlibMemCache',
			'useMemcached' => false,
			'keyPrefix'=>'sudoku.zeroq.me',//cache key 前缀
			'servers'=>array(
				array('host'=>'127.0.0.1','port'=>11211),
			),
		),
		//用户组件
		'user'=>array(
			'allowAutoLogin'=>true,
			'loginUrl'=>array('site/login'),
		),

		// cookie验证
		'request'=>array(
			'enableCookieValidation'=>true,
		),
		// 禁止调用内置的jquery文件
		'clientScript'=>array(
			'packages'=>array(
				'jquery'=>array(),
			),
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		//图片处理组件
		'image'=>array(
				'class'=>'application.extensions.image.CImageComponent',
				// GD or ImageMagick
				'driver'=>'Gmagick',
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'qicfan@gmail.com',
		'QQueue'=> array('driver'=>'memcache', 'driver_handler'=>'cache'),
	),
);
