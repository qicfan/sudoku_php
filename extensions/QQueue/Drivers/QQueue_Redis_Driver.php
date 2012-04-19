<?php

/**
 * Description of QQueue_Redis_Driver
 *
 * @author qixiaopeng <qixiaopeng@55tuan.com>
 */
class QQueue_Redis_Driver extends QQueue_Driver {

	/**
	 * 入队列
	 */
	public function push($data)
	{
		if (is_array($data)) {
			$data = serialize($data);
		}
		$this->length = $this->driver->rPush($this->key, $data);
		return;
	}

	/**
	 * 出队列
	 */
	public function pop()
	{
		$data = $this->driver->lPop($this->key);
		$rs = @unserialize($data);
		$this->length = $this->driver->lSize();
		if (!$rs || !is_array($rs)) {
			return $data;
		}
		return $rs;
	}

	/**
	 * 恢复队列长度
	 */
	public function retoreCache()
	{
		$this->length = $this->driver->lSize();
	}

}

?>
