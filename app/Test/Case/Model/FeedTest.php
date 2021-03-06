<?php
App::uses('Feed', 'Model');

/**
 * Feed Test Case
 *
 */
class FeedTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.feed',
		'app.post',
		'app.user',
		'app.feeds_user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Feed = ClassRegistry::init('Feed');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Feed);

		parent::tearDown();
	}

}
