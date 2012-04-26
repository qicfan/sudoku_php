<?php
/**
 * 商品排序
 * @author zeroq
 *
 */
class GoodsSortList {
	/**
	 * 排序的城市
	 * @var City
	 */
	private $city;
	
	/**
	 * 排序的频道
	 * @var ChannelCategory
	 */
	private $channel;
	
	/**
	 *  排序的日期（今日0或者明日1）
	 * @var int
	 */
	private $datetype;
	
	// 排序商品列表
	// e.g array(id=>position)
	private $list = array ();
	
	/**
	 * 最大排序序位
	 * @var int
	 */
	private $maxNumber;
	
	/**
	 * 是否正在排序
	 * @var bool
	 */
	private $issorting;
	
	// 每个频道最大排序序号列表, array(channel_id => max)
	private static $max = array (0 => 80, 1 => 100, 2 => 100, 3 => 100, 4 => 100, 5 => 100, 6 => 100, 7 => 100, 8 => 100, - 1 => 100 );

	/**
	 * @return the $city
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 * @return the $channel
	 */
	public function getChannel() {
		return $this->channel;
	}

	/**
	 * @return the $datetype
	 */
	public function getDatetype() {
		return $this->datetype;
	}

	/**
	 * @return the $maxNumber
	 */
	public function getMaxNumber() {
		return $this->maxNumber;
	}

	/**
	 * @param City $city
	 */
	public function setCity($city) {
		$this->city = $city;
	}

	/**
	 * @param ChannelCategory $channel
	 */
	public function setChannel($channel) {
		$this->channel = $channel;
	}

	/**
	 * @param int $datetype
	 */
	public function setDatetype($datetype) {
		$this->datetype = $datetype;
	}

	/**
	 * @param multitype: $list
	 */
	public function setList($list) {
		$this->list = $list;
	}

	/**
	 * @param int $maxNumber
	 */
	public function setMaxNumber($maxNumber) {
		$this->maxNumber = $maxNumber;
	}

	/**
	 * 获取最大序号
	 * @param int $channel_id
	 * @return int
	 */
	public static function getMax($channel_id) {
		return isset(self::$max[$channel_id]) ? self::$max[$channel_id] : 0;
	}
	
	/**
	 * 返回当前城市+频道+日期的已排序的列表
	 * 如果正在排序，则返回缓存的排序列表
	 * 如果没有排序，则返回数据库查询结果
	 * @return array  e.g array(id=>position)
	 */
	public function getList() {
		return $this->list;;
	}
	
	/**
	 * 对商品进行排序，并且重新计算列表顺序
	 * @param int $goods_id 商品ID
	 * @param int $position 商品位置
	 * @return array()
	 */
	public function resortList($goods_id, $position) {
		return array();
	}
	
	/**
	 * 保存排序列表
	 * @return bool
	 */
	public function saveList() {
		return true;
	}
	
	
}