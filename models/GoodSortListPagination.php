<?php
/**
 * 排序列表分页对象
 * 负责取出未排序的商品，并且排序
 * @author zeroq
 *
 */
class GoodSortListPagination {
	/**
	 */
	private $total;
	
	private $sortedCount;
	
	private $unsortCount;
	
	private $dataProvider;
	
	private $page;
	
	private $pagesize;
}