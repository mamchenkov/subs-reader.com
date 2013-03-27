<?php
App::uses('FeedsUser', 'Model');

/**
 * FeedsUser Test Case
 *
 */
class FeedsUserTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.feeds_user',
		'app.feed',
		'app.post',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->FeedsUser = ClassRegistry::init('FeedsUser');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->FeedsUser);

		parent::tearDown();
	}

}
