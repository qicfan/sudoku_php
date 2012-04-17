<?php
/**
 * session 集存中放memcache扩展
 * 可以指定多个memcache
 * @author Terry
 * 
 * 使用方法：
 * 配置文件中，在preload中增加sessionCache,如'preload'=>array('log','sessionCache'),
 * 然后在配置文件的components中增加如下内容
 * 'sessionCache'=>array(
 *  	'class'=>'ext.session.Sessioncache',
 *  		'servers'=>array(
 *  		array('host'=>'mem14.htp.me','port'=>'11213'),
 *			array('host'=>'mem14.htp.me','port'=>'11213','persistent'=>'1','weight'=>'1','timeout'=>'1','retry_interval'=>'15'),
 *  	)
 *  ),
 */
class SessionCache extends CApplicationComponent
{

	/**
	 *
	 * @var array cache list array;
	 */
	public $servers;
	
	/**
	 * 是否连接一次以验证memcache是否有效
	 * @var boolean
	 */
	public $tryConnect = false;

	public function init()
	{
		parent::init();
		if (!extension_loaded('Memcache')){
			throw new CException(Yii::t('yii','{className} checkd Memcache extension is not install.',
			array('{className}'=>get_class($this))));
		}
		if ($this->servers !== null && is_array($this->servers) && !empty($this->servers))
		{
			$memcachePath = '';
			foreach ($this->servers as $cache)
			{
				if (isset($cache['host']) && isset($cache['port']))
				{
					if ($this->tryConnect)
					{
						$memcache = new Memcache;
						$memcache->connect($cache['host'], $cache['port']);
					}
					
					$cache['host'] = trim($cache['host']);
					$cache['port'] = trim($cache['port']);
					$memcachePath .= 'tcp://' . $cache['host'] . ':' . $cache['port'];
					if (isset($cache['persistent']) || isset($cache['weight']) || isset($cache['timeout']) || isset($cache['retry_interval']) )
					{
						$memcachePath .= '?'. (isset($cache['persistent']) ? 'persistent='.$cache['persistent'] : '');
						isset($cache['weight']) && $memcachePath .= '&weight='.$cache['weight'];
						isset($cache['timeout']) && $memcachePath .= '&timeout='.$cache['timeout'];
						isset($cache['retry_interval']) && $memcachePath .= '&retry_interval='.$cache['retry_interval'];
					}
					$memcachePath .= ',';
				}
			}
			if ($memcachePath)
			{
				$memcachePath = substr($memcachePath, 0, -1);
				ini_set('session.save_handler', 'memcache');
				ini_set('session.save_path', $memcachePath);
				// session有效期24小时
				session_cache_expire(24*60);
			}
		}
	}

}