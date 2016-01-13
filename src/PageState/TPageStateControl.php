<?php
/**
 * Created by IntelliJ IDEA.
 * User: pepin_000
 * Date: 13. 1. 2016
 * Time: 18:28
 */

namespace Peping\PageState;


trait TPageStateControl
{
	use TPageState;

	/**
	 * @var IPageStateControlFactory
	 */
	protected $pageStateControlFactory;

	public function injectPageStateControlFactory(IPageStateControlFactory $pageStateControlFactory)
	{
		$this->pageStateControlFactory = $pageStateControlFactory;
	}

	public function createComponentPageStateControl()
	{
		return $this->pageStateControlFactory->create();
	}
}