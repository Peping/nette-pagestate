# nette-pagestate

Nette Pagestate is a library that helps keep a [nette](http://github.com/nette/nette) application state between subrequests (signals) by storing the state in the browser's DOM and submitting it to the server each time a subrequest is made via AJAX (using [nette.ajax.js](https://github.com/vojtech-dobes/nette.ajax.js). It is especially useful in situations when you need to create more complex and interactive nette components using javascript, but your project's UI and most operations still need to be done on the server. 

**BE SURE TO ALSO INSTALL THE CLIENT SIDE:** [peping/nette.pagestate.js](https://github.com/Peping/nette.pagestate.js)

## Installation
Use Composer to install the server-side package:
```
composer install peping/nette-pagestate
```

## Usage
Ensure that your application loads composer packages correctly (i. e. includes `autoload.php`). If you want to use pagestate inside a component (instead of just a presenter), make sure that it has [autowiring](https://pla.nette.org/cs/inject-autowire) enabled.

At the start of the class, use the `TPageState` trait. This allows you to set the page state.
```php
class HomePresenter extends Presenter
{
use TPageState;
...
}
```

Every component in your application has its own page state designated by its `uniqueId`. You can set and get values like this:

```php
public function render()
{
	$pagestate = $this->getPageState();
	
	// Get the number of times the button has been clicked in the browser's currently loaded page

	// PHP 7
	$clickCount = $pageState->clickCount ?? 0;

	// PHP 5
	$clickCount = isset($pageState->clickCount) ? $pageState->clickCount : 0;
}

public function handleClick()
{
	// The button has been clicked, increment the click count and redraw the button's snippet

	// PHP 7
	$pageState->clickCount = ($pageState->clickCount ?? 0) + 1

	// PHP 5
	$pageState->clickCount = isset($pageState->clickCount) ? $pageState->clickCount + 1 : 1;
}
```