<?php
namespace Peping\PageState;

trait TPageState
{
	/**
	 * @return \Nette\Utils\ArrayHash
	 */
	public function getPageState()
	{
		return $this->presenter['pageStateControl']->getStateForComponent($this->name);
	}
}