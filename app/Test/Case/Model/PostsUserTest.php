<?php
App::uses('PostsUser', 'Model');

/**
 * PostsUser Test Case
 *
 */
class PostsUserTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.posts_user',
		'app.post',
		'app.feed',
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
		$this->PostsUser = ClassRegistry::init('PostsUser');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PostsUser);

		parent::tearDown();
	}

}
