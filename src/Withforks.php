<?php
namespace Palmero;

use Psr\Container\{
	ContainerInterface,
	ContainerExceptionInterface,
	NotFoundExceptionInterface
};

/**
 * Inherit this class, define methods called "getSomething" and access them
 * as $container->something.
 *
 * Each time a property is called for the first time, it will lazily
 * instantiate it and store it for future calls.
 *
 * The `getSomething` methods will be only called once, returning always the 
 * same value.
 *
 * @author Lucas Palmero <lucas@placeholder.com.ar>
 */
abstract class Withforks implements ContainerInterface {

	/**
	 * This array holds every method's return value, so we don't call those
	 * methods more times than needed.
	 *
	 * @var array[mixed]mixed
	 */
	private $resultCache;

	/**
	 * Holds the settings. It should be an associative array.
	 *
	 * @var array[mixed]mixed
	 */
	private $settings;

	/**
	 * @param array[mixed]mixed $settings
	 */
	final public function __construct(array $settings) {
		$this->settings = $settings;
	}

	/**
	 * Checks if a method exists to retrieve, store and return its value. If the
	 * method was already called, it will get the stored value instead of
	 * calling it again.
	 *
	 * @param mixed $name
	 * @return mixed
	 */
	final public function get($name) {
		$methodName = $this->nameToMethodName($name);

		if (isset($this->resultCache[$name])) {
			return $this->resultCache[$name];
		}

		if ($this->has($name)) {
			$this->resultCache[$name] = $this->$methodName();
			return $this->resultCache[$name];
		}

		throw new WithforksNotFoundException(
			"Container $name or method $methodName not found."
		);
	}

	/**
	 * Checks if a value exists.
	 *
	 * @param mixed $name
	 * @return bool
	 */
	final public function has($name) {
		$methodName = $this->nameToMethodName($name);
		return method_exists($this, $methodName);
	}

	/**
	 * Magic method binding for the get() method.
	 *
	 * @param mixed $name
	 * @return mixed
	 */
	final public function __get($name) {
		return $this->get($name);
	}

	/**
	 * Returns the settings.
	 *
	 * @return array[mixed]mixed
	 */
	final public function getSettings() : array {
		return $this->settings;
	}

	/**
	 * Gets `someName` and transforms it to `getSomeName`.
	 *
	 * @param string $Name
	 * @return string
	 */
	private function nameToMethodName(string $name) : string {
		return "get".ucfirst($name);
	}

}

class WithforksException extends \Exception implements ContainerExceptionInterface {}
class WithforksNotFoundException extends WithforksException implements NotFoundExceptionInterface {}
