# Withforks

A PSR-11 class-inheriting implementation

# Example

```
use Palmero\Withforks;

class Container extends Withforks {

	protected function getSomeClass() {
		return new SomeClass(
			$this->getSettings()['someClass']
		);
	}

	protected function getSomeOtherClass() {
		return new SomeOtherClass(
			$this->getSettings()['someOtherClass']
		);
	}

}
```

To instantiate the container, just pass it an associative array with the configs required for each method:

```
$container = new Container([
	'someClass' => [
		'config' => true
	],
	'someOtherClass' => [
		'config' => "something"
	],
]);
```

You can access everything...:

  * The PSR-11 way: `$container->has('someClass')` and `$container->get('someClass')`
  * The Withforks way: `$container->someClass`
