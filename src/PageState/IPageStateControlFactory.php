<?php
namespace Peping\PageState;

interface IPageStateControlFactory
{
	/**
	 * @return PageState
	 */
	public function create();
}