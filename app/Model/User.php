<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Feed $Feed
 * @property Post $Post
 */
class User extends AppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'name';

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasAndBelongsToMany associations
	 *
	 * @var array
	 */
	public $hasAndBelongsToMany = array(
		'Feed' => array(
			'className' => 'Feed',
			'joinTable' => 'feeds_users',
			'foreignKey' => 'user_id',
			'associationForeignKey' => 'feed_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Post' => array(
			'className' => 'Post',
			'joinTable' => 'posts_users',
			'foreignKey' => 'user_id',
			'associationForeignKey' => 'post_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

	/**
	 * beforeSave() callback
	 * 
	 * @param array $options Options
	 * @return boolean
	 */
	public function beforeSave($options = array()) {
		if (isset($this->data['User']['password'])) {
			$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
		}
		return true;
	}

	/**
	 * afterSave() callback
	 * 
	 * @param boolean $created True if record was created
	 * @return void
	 */
	public function afterSave($created) {
		if ($created) {
			$result = $this->subscribeToFeed('http://mamchenkov.net/wordpress/feed/');
			debug($result);
		}
	}
	
	/**
	 * Subscribe to feed
	 * 
	 * @param string $feedUrl Feed Url
	 * @param numeric $userId User ID (optional)
	 * @return boolean True on success, false otherwise
	 * @throws InvalidArgumentException
	 * @throws RuntimeException
	 */
	public function subscribeToFeed($feedUrl, $userId = null) {
		$result = false;

		if (empty($userId)) { $userId = $this->id; }

		if (empty($userId))  { throw new InvalidArgumentException("Missing user ID"); }
		if (empty($feedUrl)) { throw new InvalidArgumentException("Missing feed URL"); }

		try {
			$feed = ClassRegistry::init('Feed');
			$feedId = $feed->add($feedUrl);
			
			$subscription = array();
			$subscription['User'] = array();
			$subscription['User']['id'] = $userId;
			$subscription['Feed'] = array();
			$subscription['Feed']['id'] = $feedId;

			$result = $this->save($subscription);
		}
		catch (Exception $e) {
			// NOP
		}
		
		return $result;
	}
}
