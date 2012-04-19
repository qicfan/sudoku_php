<?php
Yii::import("application.extensions.QQueue.drivers.*");
/**
 * 基于redis或者memcache的一个php队列
 * 基于php-fpm实现，必须运行在fastcgi模式下
 * e.g.
 * 'params'=>array(
		'QQueue'=> array('driver'=>'memcache', 'driver_handler'=>'cache'),
	),
 *
 *
 * @author qixiaopeng <qixiaopeng@55tuan.com>
 */
class QQueue {

	/**
	 * 使用的存储驱动，默认为redis
	 * 可选值为redis|memcache
	 * @var string
	 */
	public $driver = 'redis';

	/**
	 * 配置文件中传递的参数
	 * @var type
	 */
	public $params = array();

	/**
	 * 队列名称，每个名称只能存在一个队列实例
	 * @var type
	 */
	private $name;

	/**
	 * 所有队列实例的数组
	 * @var type
	 */
	private static $queues = array();

	/**
	 * 单例模式，得到一个队列的唯一实例
	 * @params string $name 队列名称
	 */
	public static function createQueue($name)
	{
		if (!$name)
		{
			return null;
		}
		$key = md5($name);
		if (isset(self::$queues[$key]))
		{
			return self::$queues[$key];
		}
		$queue = new QQueue($name);
		self::$queues[$key] = $queue;
		return $queue;
	}

	public function __construct($name)
	{
		$this->name = $name;
		$this->getParams();
		// 判断运行环境是否满足条件
		$this->checkPhpFpm();
		$this->checkRedis();
		$this->checkMemcache();
		$this->getDriver();
	}

	/**
	 * 获得配置文件中的参数
	 * @throws CException
	 */
	private function getParams()
	{
		if (!isset(Yii::app()->params['QQueue']))
		{
			throw new CException('To add the "QQueue" to the configuration file, see example at top of this file.');
		}
		$this->params = Yii::app()->params['QQueue'];
	}

	private function getDriver()
	{
		if (!isset($this->params['driver']) || !isset($this->params['driver_handler'])) {
			throw new CException('QQueue config error');
		}
		// Set driver class name
		$driver = 'QQueue_'.ucfirst($this->params['driver']).'_Driver';
		// Initialize the driver
		$this->driver = new $driver($this->params, $this->name);
		return;
	}

	/**
	 * 检查是否运行在php-fpm下，是否存在必须的fastcgi_finish_request方法
	 * @throws CException
	 */
	private function checkPhpFpm()
	{
		if (!function_exists('fastcgi_finish_request'))
		{
			throw new CException('must be run in fastcgi mode using php-fpm');
		}
	}

	/**
	 * 如果存储驱动是Memcache，那检查是否存在memcache或者memcached扩展
	 * @throws CException
	 */
	private function checkMemcache()
	{
		if ($this->driver == 'memcache' && (!extension_loaded('memcache') || !extension_loaded('memcached')))
		{
			throw new CException('must been installed memcache|memcached extension');
		}
		require_once 'QQueue_Memcache_Driver.php';
	}

	/**
	 * 如果存储驱动是Redis，那检查是否存在redis扩展
	 * @throws CException
	 */
	private function checkRedis()
	{
		if ($this->driver == 'redis' && !extension_loaded('redis'))
		{
			throw new CException('must been installed redis extension');
		}
		require_once 'QQueue_Redis_Driver.php';
	}

	/**
	 * getter for $this->isLock
	 * 返回是否锁定
	 * @return type
	 */
	public function isLock()
	{
		return $this->driver->isLock();
	}

	/**
	 * 加锁
	 * 调用存储驱动的加锁方法，并且设置本身的锁状态为true
	 */
	public function lock()
	{
		fastcgi_finish_request();
		return $this->driver->lock();
	}

	/**
	 * 入队列
	 */
	public function push($data)
	{
		return $this->driver->push($data);
	}

	/**
	 * 出队列
	 */
	public function pop()
	{
		return $this->driver->pop();
	}

	/**
	 * 队列是否为空
	 */
	public function isEmpty()
	{
		return $this->driver->isEmpty();
	}

	/**
	 * 队列长度
	 */
	public function length()
	{
		return $this->driver->length;
	}

	/**
	 * 运行worker进程
	 */
	public function start() {
		if ($this->isLock()) {
			exit();
		} else {
			$this->lock();
			$this->callback();
		}
	}

	/**
	 * 执行注册的worker
	 * @return type
	 */
	public function callback() {
		if (!isset($this->params['callback']) || !isset($this->params['callback'][$this->name])) {
			return;
		}
		$callback = $this->params['callback'][$this->name];
		while (!$this->isEmpty()) {
			call_user_func($callback, $this->pop());
		}
		return;
	}

}

?>
