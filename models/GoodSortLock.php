<?php
/**
 * 排序锁
 * @author zeroq
 *
 */
class GoodsSortLock {
	/**
	 * 是否锁定，如果是false,则意味着没有人得到锁
	 * @var bool
	 */
	public static $lock;
	
	/**
	 * 用户名
	 * @var string
	 */
	public static $username;
	
	/**
	 * 用户ID
	 * @var int
	 */
	public static $userId;
	
	/**
	 * 锁定时间，时间戳
	 * @var int
	 */
	public static $lockTime;
	
	/**
	 * 超时时间，单位秒
	 * @var int
	 */
	public static $expiryTime;
	
	/**
	 * 锁中存放的数据
	 * @var array
	 */
	public static $data;
	
	/**
	 * 加锁
	 */
	public static function lock() {
		
	}
	
	/**
	 * 解锁
	 */
	public static function unlock() {
		
	}
	
	/**
	 * 是否锁定
	 */
	public static function isLock() {
		
	}
}
