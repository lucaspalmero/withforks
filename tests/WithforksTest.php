<?php
namespace Palmero\Withforks\Tests;

use Palmero\Withforks;
use Palmero\WithforksNotFoundException;
use PHPUnit\Framework\TestCase;

class WithforksTest extends TestCase {

	private $implementation;

	public function setUp() {
		$this->implementation = new MockWithforksImplementation([
			"setting" => "wow"
		]);
	}

	public function testStuffNotChanging() {
		$randomOne = $this->implementation->randOne;
		$randomTwo = $this->implementation->randTwo;
		$randomThree = $this->implementation->get('randThree');

		$this->assertEquals($randomOne, $this->implementation->randOne);
		$this->assertEquals($randomTwo, $this->implementation->get('randTwo'));
		$this->assertEquals($randomThree, $this->implementation->randThree);

		$this->assertTrue($this->implementation->has('randOne'));
		$this->assertTrue($this->implementation->has('randTwo'));
		$this->assertTrue($this->implementation->has('randThree'));
		$this->assertFalse($this->implementation->has('randFour'));

		$this->assertEquals("wow", $this->implementation->setting);
	}

	/**
	 * @expectedException \Palmero\WithforksNotFoundException
	 */
	public function testFailure() {
		$a = $this->implementation->somethingThatDoesntExist;
	}
}
