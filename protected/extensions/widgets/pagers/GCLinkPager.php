<?php
/**
 * CLinkPager class file.
 *
 * @author Gustavo Salgado <gsalgadotoledo@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CLinkPager displays a list of hyperlinks that lead to different pages of target.
 *
 * @author Gustavo Salgado <gsalgadotoledo@gmail.com>
 * @package system.web.widgets.pagers
 * @since 1.0
 */
class GCLinkPager extends CLinkPager
{
	const CSS_FIRST_PAGE='pag-tx tr';
	const CSS_LAST_PAGE='pag-tx tr';
	const CSS_PREVIOUS_PAGE='pag-tx tr';
	const CSS_NEXT_PAGE='pag-tx tr';
	const CSS_INTERNAL_PAGE='pag-num tr';
	const CSS_HIDDEN_PAGE='hidden';
	const CSS_SELECTED_PAGE='pag-num tr pag-act';


/**
	 * @var string the CSS class for the first page button. Defaults to 'first'.
	 * @since 1.1.11
	 */
	public $firstPageCssClass=self::CSS_FIRST_PAGE;
	/**
	 * @var string the CSS class for the last page button. Defaults to 'last'.
	 * @since 1.1.11
	 */
	public $lastPageCssClass=self::CSS_LAST_PAGE;
	/**
	 * @var string the CSS class for the previous page button. Defaults to 'previous'.
	 * @since 1.1.11
	 */
	public $previousPageCssClass=self::CSS_PREVIOUS_PAGE;
	/**
	 * @var string the CSS class for the next page button. Defaults to 'next'.
	 * @since 1.1.11
	 */
	public $nextPageCssClass=self::CSS_NEXT_PAGE;
	/**
	 * @var string the CSS class for the internal page buttons. Defaults to 'page'.
	 * @since 1.1.11
	 */
	public $internalPageCssClass=self::CSS_INTERNAL_PAGE;
	/**
	 * @var string the CSS class for the hidden page buttons. Defaults to 'hidden'.
	 * @since 1.1.11
	 */
	public $hiddenPageCssClass=self::CSS_HIDDEN_PAGE;
	/**
	 * @var string the CSS class for the selected page buttons. Defaults to 'selected'.
	 * @since 1.1.11
	 */
	public $selectedPageCssClass=self::CSS_SELECTED_PAGE;
	/**
	 * @var integer maximum number of page buttons that can be displayed. Defaults to 10.
	 */
	
	public $maxButtonCount=3;
	public $header=false;
	/**
	 * @var string the text shown after page buttons.
	 */
	public $footer='';
	/**
	 * @var mixed the CSS file used for the widget. Defaults to null, meaning
	 * using the default CSS file included together with the widget.
	 * If false, no CSS file will be used. Otherwise, the specified CSS file
	 * will be included when using this widget.
	 */
	public $cssFile=false;

	/**
	 * Initializes the pager by setting some default property values.
	 */
	public function init()
	{
		if($this->nextPageLabel===null)
			$this->nextPageLabel='... ›';
		if($this->prevPageLabel===null)
			$this->prevPageLabel='‹ ...';
		if($this->firstPageLabel===null)
			$this->firstPageLabel='«';
		if($this->lastPageLabel===null)
			$this->lastPageLabel='»';
		if($this->header===null)
			$this->header=Yii::t('yii','Go to page: ');

		if(!isset($this->htmlOptions['id']))
			$this->htmlOptions['id']=$this->getId();
		if(!isset($this->htmlOptions['class']))
			$this->htmlOptions['class']='yiiPager';
	}

	/**
	 * Executes the widget.
	 * This overrides the parent implementation by displaying the generated page buttons.
	 */
	public function run()
	{
		$this->registerClientScript();
		$buttons=$this->createPageButtons();
		if(empty($buttons))
			return;
		echo $this->header;
		echo implode("\n",$buttons);
		echo $this->footer;
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

		// first page
		$buttons[]=$this->createPageButton($this->firstPageLabel,0,$this->firstPageCssClass,$currentPage<=0,false);

		// prev page
		if(($page=$currentPage-1)<0)
			$page=0;
		$buttons[]=$this->createPageButton($this->prevPageLabel,$page,$this->previousPageCssClass,$currentPage<=0,false);

		// internal pages
		for($i=$beginPage;$i<=$endPage;++$i)
			$buttons[]=$this->createPageButton($i+1,$i,$this->internalPageCssClass,false,$i==$currentPage);

		// next page
		if(($page=$currentPage+1)>=$pageCount-1)
			$page=$pageCount-1;
		$buttons[]=$this->createPageButton($this->nextPageLabel,$page,$this->nextPageCssClass,$currentPage>=$pageCount-1,false);

		// last page
		$buttons[]=$this->createPageButton($this->lastPageLabel,$pageCount-1,$this->lastPageCssClass,$currentPage>=$pageCount-1,false);

		return $buttons;
	}

	/**
	 * Creates a page button.
	 * You may override this method to customize the page buttons.
	 * @param string $label the text label for the button
	 * @param integer $page the page number
	 * @param string $class the CSS class for the page button.
	 * @param boolean $hidden whether this page button is visible
	 * @param boolean $selected whether this page button is selected
	 * @return string the generated button
	 */
	protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		if($hidden || $selected)
			$class.=' '.($hidden ? $this->hiddenPageCssClass : $this->selectedPageCssClass);
		return ''.CHtml::link($label,$this->createPageUrl($page),array('class'=>$class)).'';
	}
}
