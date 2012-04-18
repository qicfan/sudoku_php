<?php

$yii = 'yii.php';
$basepath = dirname(__FILE__) . DIRECTORY_SEPARATOR;
define('BASEPATH', $basepath);
$config_dir = BASEPATH . 'config';
$mode_file = $config_dir . '/mode.conf';

if (file_exists($mode_file))
{
	$mode = trim(file_get_contents($mode_file));
	$config = $config_dir . '/' . $mode . '.php';

	if (!preg_match("/^\w+$/", $mode))
		die('mode error!');
	if (!file_exists($config))
		die('Mode config file is not exists.');

	if ($mode == 'local' || $mode == 'local_example')
	{
		defined('YII_DEBUG') or define('YII_DEBUG', true);
		// specify how many levels of call stack should be shown in each log message
		defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
	}
}
else
{
	$config = $config_dir . '/main.php';
}

if (extension_loaded('apc'))
	$yii = 'yiilite.php';

require_once ($yii);

Yii::createWebApplication($config)->run();
