<?php
namespace Peping\PageState;

interface IPageStateControlFactory
{
	/**
	 * @return PageStateControl
	 */
	public function create();
}