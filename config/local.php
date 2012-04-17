<?php
/**
 * 包含主配置文件
 * 当有差异的数组或要删除的数组的时候，才需要unset，否则如果重写结构一样的数组可以不必unset
 */
$main_conf = require(dirname(__FILE__).'/main.php');
// 注销掉main中的配置
return CMap::mergeArray(
	$main_conf,
	array(
		'components'=>array(
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

		),
	)
);
