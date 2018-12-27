<?php
namespace Palmero\Withforks\Tests;

use Palmero\Withforks;

class MockWithforksImplementation extends Withforks {

	protected function getRandOne() {
		return rand();
	}

	protected function getRandTwo() {
		return rand();
	}

	protected function getRandThree() {
		return rand();
	}

	protected function getSetting() {
		return $this->getSettings()['setting'];
	}
}
