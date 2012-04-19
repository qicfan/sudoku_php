<?php
/**
 * 包含主配置文件
 * 当有差异的数组或要删除的数组的时候，才需要unset，否则如果重写结构一样的数组可以不必unset
 */
$main_conf = require(dirname(__FILE__).'/main.php');
// 注销掉main中的配置
unset($main_conf['components']['cache']);
unset($main_conf['components']['urlManager']);
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

			// 远程cache
			'cache'=>array(
				'class'=>'ext.cache.ZlibMemCache',
				'useMemcached' => true,
				'keyPrefix'=>'sudoku.zeroq.me',//cache key 前缀
				'servers'=>array(
					array('host'=>'127.0.0.1','port'=>11211),
				),
			),

		),
	)
);
