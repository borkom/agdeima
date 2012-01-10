<?php
/* Image Test cases generated on: 2012-01-08 20:54:48 : 1326052488*/
App::uses('Image', 'Model');

/**
 * Image Test Case
 *
 */
class ImageTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.image', 'app.post');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Image = ClassRegistry::init('Image');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Image);

		parent::tearDown();
	}

}
