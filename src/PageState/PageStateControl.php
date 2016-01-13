<?php

namespace Peping\PageState;

use Nette\Application\UI\Presenter;
use Nette\Http\IRequest;
use Nette\Http\Request;
use Nette\Utils\ArrayHash;
use Nette\Utils\Html;

class PageStateControl extends \Nette\Application\UI\Control
{
	/**
	 * @var \Nette\Utils\ArrayHash
	 */
	protected $state;

	/**
	 * @var IRequest
	 */
	protected $httpRequest;

	/**
	 * @var Presenter
	 */
	protected $myPresenter;


	public function injectHttpRequest(\Nette\Http\IRequest $httpRequest)
	{
		$this->httpRequest = $httpRequest;
		$this->setState();
	}

	/**
	 * @param mixed $presenter The attached component
	 */
	public function attached($presenter)
	{
		if ($presenter instanceof Presenter) {
			/**
			 * @var \Nette\Application\UI\Presenter $presenter;
			 */
			$this->myPresenter = $presenter;
			$this->setState();
		}
	}

	protected function setState()
	{
		$this->state = new ArrayHash();
		if (!$this->myPresenter || !$this->httpRequest) {
			return;
		}

		$this->state = \Nette\Utils\Json::decode(
			$this->httpRequest->getHeader('X-Nette-Pagestate','{}')
		);

		$this->redrawControl();
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
		if ($this->httpRequest->isAjax()) {
			if (!isset($this->myPresenter->payload->snippets)) {
				$this->myPresenter->payload->snippets = [];
			}

			$this->myPresenter->payload->snippets[$this->getSnippetId('state')] = $this->getStateElement()->render();
		} else {
			echo Html::el('span', ['id' => $this->getSnippetId('state')])
				->add($this->getStateElement());
		}
	}

	/**
	 * @return Html
	 */
	protected function getStateElement()
	{
		return Html::el('span', ['id' => 'nette-pagestate-container', 'data-state' => \Nette\Utils\Json::encode($this->state)]);
	}
}