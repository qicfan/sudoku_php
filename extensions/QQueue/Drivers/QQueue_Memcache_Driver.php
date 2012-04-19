<?php

/**
 * Description of QQueue_Memcache_Driver
 *
 * 必须在配置文件中有一个指定的memcache缓存：
 *
 * 'QQueueCache'=>array(
 * 'class'=>'ext.cache.ZlibMemCache',
 * 'keyPrefix'=>'QQueue',//cache key 前缀
 * 'servers'=>array(
 * array('host'=>'127.0.0.1','port'=>11211),
 * ),
 * ),
 *
 *
 * @author qixiaopeng <qixiaopeng@55tuan.com>
 */
class QQueue_Memcache_Driver extends QQueue_Driver {

	/**
	 * 入队列
	 */
	public function push($data)
	{
		$queue = $this->driver->get($this->key);
		if (!is_array($queue)) {
			$queue = array();
		}
		$queue[] = $data;
		$this->increaseLength();
		return $this->driver->set($this->key, $queue);
	}

	/**
	 * 出队列
	 */
	public function pop()
	{
		$queue = $this->driver->get($this->key);
		if (count($queue) == 0)
		{
			$this->length = 0;
			return false;
		}
		$return = array_shift($queue);
		$this->decreaseLength();
		$this->driver->set($this->key, $queue);
		return $return;
	}

	/**
	 * 恢复队列长度
	 */
	public function retoreQueue()
	{
		$data = $this->driver->get($this->key);
		if (is_array($data)) {
			$this->length = count($data);
			return;
		}
		$this->length = 0;
	}

}

?>
