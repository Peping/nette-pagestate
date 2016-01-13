<?php

namespace Peping\PageState;

class PageStateControl extends \Nette\Application\UI\Control
{
	/**
	 * @var \Nette\Utils\ArrayHash
	 */
	protected $state;

	public function __construct()
	{
		$this->monitor('Nette\Application\UI\Presenter');
	}

	/**
	 * @param mixed $presenter The attached component
	 */
	public function attached($presenter)
	{
		if ($presenter instanceof \Nette\Application\UI\Presenter) {
			/**
			 * @var \Nette\Application\UI\Presenter $presenter;
			 */
			$this->state = \Nette\Utils\Json::decode(
				$presenter->getHttpRequest()->getHeader('X-NETTE-PAGESTATE','{}')
			);
		}
	}

	public function getStateForComponent(\Nette\ComponentModel\IComponent $component)
	{
		$name = $component->getName();

		if (isset($this->state->$name))
		{
			return $this->state->$name;
		} else {
			$state = new \Nette\Utils\ArrayHash();
			$this->state->$name = $state;
			return $state;
		}
	}

	public function render()
	{
		echo \Nette\Utils\Html::el('span',['id' => 'nette-pagestate-container', 'data-state' => \Nette\Utils\Json::encode($this->state)]);
	}
}