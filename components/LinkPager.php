<?php
/**
 * 分页类
 * @author sangxiaolong
 *
 */
class LinkPager extends CLinkPager
{	
	public $maxButtonCount=7;
	public $header = false;
	public $cssFile = false;
	public $firstPageLabel = '第一页';
	public $lastPageLabel = '最后一页';
	public $nextPageLabel = '下一页';
	public $prevPageLabel = '上一页';
	/**
	 * Executes the widget.
	 * This overrides the parent implementation by displaying the generated page buttons.
	 */
	public function run()
	{
		$buttons=$this->createPageButtons();
		if(empty($buttons))
			return;
		echo $this->header;
		echo CHtml::tag('div',$this->htmlOptions,implode("\n",$buttons));
		echo $this->footer;
	}
	
	/**
	 * @return array the begin and end pages that need to be displayed.
	 */
	protected function getPageRange()
	{
		$currentPage=$this->getCurrentPage();
		$pageCount=$this->getPageCount();
		
		$beginPage=max(0, $currentPage-(int)($this->maxButtonCount/2));

		if(($endPage=$beginPage+$this->maxButtonCount-1)>=$pageCount)
		{
			$endPage=$pageCount-1;
			$beginPage=max(0,$endPage-$this->maxButtonCount+1);
		}
		return array($beginPage,$endPage);
	}
	
	/**
	 * Creates the page buttons.
	 * @return array a list of page buttons (in HTML code).
	 */
	protected function createPageButtons()
	{
		if(($pageCount=$this->getPageCount())<=1)
			return array();

		list($beginPage,$endPage)=$this->getPageRange();
		$currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
		$buttons=array();
		$buttons[]='<span>共计'.$this->getItemCount().'条</span>';
		
		// first page
		$buttons[]=$this->createPageButton($this->firstPageLabel,0,self::CSS_FIRST_PAGE,$currentPage<=0,false);

		// prev page
		if(($page=$currentPage-1)<0)
			$page=0;
			
		$buttons[]=$this->createPageButton($this->prevPageLabel,$page,self::CSS_PREVIOUS_PAGE,$currentPage<=0,false);
		
		// first page
		//if($currentPage>(int)$this->maxButtonCount/2+1)
		//{
		//	$buttons[]=$this->createPageButton('1',0,self::CSS_INTERNAL_PAGE,false,false);
		//}

		// ...
		//if($currentPage-(int)$this->maxButtonCount/2>1 && $pageCount>$this->maxButtonCount)
		//	$buttons[]='<span>...</span>';
			
		// internal pages
		for($i=$beginPage;$i<=$endPage;++$i)
			$buttons[]=$this->createPageButton($i+1,$i,self::CSS_INTERNAL_PAGE,false,$i==$currentPage);
		// ...
		if($currentPage+(int)$this->maxButtonCount/2<($pageCount-2) && $pageCount>$this->maxButtonCount)
			$buttons[]='<span>...</span>';
			
		// last page
		if(($pageCount-$currentPage)>(int)$this->maxButtonCount/2+1 && $pageCount>$this->maxButtonCount)
		{
			$buttons[]=$this->createPageButton($pageCount, $pageCount, self::CSS_INTERNAL_PAGE, false, false);
		}
		// next page
		if(($page=$currentPage+1)>=$pageCount-1)
			$page=$pageCount-1;
		$buttons[]=$this->createPageButton($this->nextPageLabel,$page,self::CSS_NEXT_PAGE,$currentPage>=$pageCount-1,false);
		
		// last page
		$buttons[]=$this->createPageButton($this->lastPageLabel,$pageCount-1,self::CSS_LAST_PAGE,$currentPage>=$pageCount-1,false);
		$buttons[]='跳转到<input type="text" size="10" value="" id="jump_input"/>页';
		$buttons[]='<button id="jump_button" class="turn">跳转</button>';
		$perpage=Yii::app()->request->getParam('perpage',10);
		$buttons[]='每页显示
		<select id="perpage" name="per_page">
			<option value="10"'.($perpage==10?' selected="selected"':'').'>10</option>
			<option value="20"'.($perpage==20?' selected="selected"':'').'>20</option>
			<option value="40"'.($perpage==40?' selected="selected"':'').'>40</option>
		</select>';
		return $buttons;
	}
	
	protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		if($selected)
		{
			return '<span>'.($page+1).'</span>';
		}
		if ($hidden)
		{
			$link = "";
		}
		else
		{
			$link = $this->createPageUrl($page);
			return CHtml::link($label,$link,$htmlOptions=array('class'=>$class));
		}
	}
}