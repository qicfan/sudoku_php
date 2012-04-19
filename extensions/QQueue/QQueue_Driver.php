<?php

/**
 * 队列存储驱动接口
 * @author qixiaopeng <qixiaopeng@55tuan.com>
 */
class QQueue_Driver
{
	public $length;
	public $params;
	public $name;
	public $key;
	public $driver;

	/**
	 * 实例化存储驱动
	 * @param array $params 配置文件中配置的参数
	 * @param string $name 队列名称
	 */
	function __construct($params, $name)
	{
		$this->params = $params;
		$this->name = $name;
		$this->setKey();
		$this->checkQueue();
		$this->retoreQueue();
	}

	/**
	 * setter for $this->key
	 */
	public function setKey()
	{
		return $this->key = 'q_' . $this->name;
	}

	/**
	 * 检查是否有对应的配置项
	 * @throws CException
	 */
	public function checkQueue()
	{
		$handler = $this->params['driver_handler'];
		if (!isset(Yii::app()->$handler))
		{
			throw new CException('To add ' . $handler . ' to the configuration file, and view example at the top.');
		}
		$this->driver = Yii::app()->$handler;
	}

	/**
	 * 查询是否有锁定
	 */
	public function isLock()
	{
		$rs = $this->driver->get('QQueue_lock');
		if ($rs != 1)
		{
			return false;
		}
		return true;
	}

	/**
	 * 锁定
	 */
	public function lock()
	{
		return $this->driver->set('QQueue_lock', 1);
	}

	/**
	 * 入队列
	 */
	public function push($data)
	{
		
	}

	/**
	 * 出队列
	 */
	public function pop()
	{

	}

	/**
	 * 增加队列长度
	 * @return type
	 */
	public function decreaseLength()
	{
		$this->length--;
		if ($this->length < 0)
		{
			$this->length = 0;
		}
		return;
	}

	/**
	 * 减少队列长度
	 * @return type
	 */
	public function increaseLength()
	{
		$this->length++;
		return;
	}

	/**
	 * 恢复队列长度
	 */
	public function retoreQueue()
	{

	}

	/**
	 * 是否为空
	 */
	public function isEmpty()
	{
		if ($this->length > 0)
		{
			return false;
		}
		return true;
	}
}

?>
