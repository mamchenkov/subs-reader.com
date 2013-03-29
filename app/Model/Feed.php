<?php
App::uses('AppModel', 'Model');
/**
 * Feed Model
 *
 * @property Post $Post
 * @property User $User
 */
class Feed extends AppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'title';

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'url_hash' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'url' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'title' => array(
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
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'Post' => array(
			'className' => 'Post',
			'foreignKey' => 'feed_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);


	/**
	 * hasAndBelongsToMany associations
	 *
	 * @var array
	 */
	public $hasAndBelongsToMany = array(
		'User' => array(
			'className' => 'User',
			'joinTable' => 'feeds_users',
			'foreignKey' => 'feed_id',
			'associationForeignKey' => 'user_id',
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
	 * Normalize URL
	 * 
	 * @param string $url URL to normalize
	 * @return string Normalized URL
	 */
	public function normalizeUrl($url) {
		$result = '';

		$parts = parse_url($url);
		$result = strtolower($parts['scheme']) . '://';
		if (!empty($parts['user'])) {
			$result .= $parts['user'];
			if (!empty($parts['pass'])) {
				$result .= ':' . $parts['pass'];
			}
			$result .= '@';
		}
		$result .= strtolower($parts['host']);
		if (!empty($parts['port'])) {
			if ($parts['port'] == '80' && strtolower($parts['scheme']) == 'http'
				|| $parts['port'] == '443' && strtolower($parts['scheme']) == 'https') {
					// NOP
			}
			else {
				$result .= ':' . $parts['port'];
			}
		}

		if (!empty($parts['path'])) {
			$result .= $parts['path'];
		}
		else {
			$result .= '/';
		}

		if (!empty($parts['query'])) {
			$result .= '?' . $parts['query'];
		}

		if (!empty($parts['fragment'])) {
			$result .= '#' . $parts['fragment'];
		}

		return $result;
	}

	/**
	 * Checksum URL
	 * 
	 * @param string $url URL to checksum
	 * @return string Checksum
	 */
	public function checkSum($url) {
		return md5($url);
	}

	/**
	 * Add new feed
	 * 
	 * @param string $feedUrl Feed URL
	 * @return numeric|null Feed ID
	 */
	public function add($feedUrl) {
		$result = null;

		if (empty($feedUrl)) { 
			throw new InvalidArgumentException("Missing feed URL"); 
		}

		$feedUrl = $this->normalizeUrl($feedUrl);
		$feedHash = $this->checkSum($feedUrl);
		
		$feed = $this->findByUrl_hash($feedHash);	
		if (empty($feed)) {
			$newFeed = array();
			$newFeed['Feed'] = array();
			$newFeed['Feed']['url_hash'] = $feedHash;
			$newFeed['Feed']['url'] = $feedUrl;
			$newFeed['Feed']['title'] = $feedUrl;
			$this->create();
			if ($this->save($newFeed)) {
				$result = $this->id;
			}
		}

		return $result;
	}

	/**
	 * Find feed candidates to fetch
	 * 
	 * @todo Move hardcoded limit to configuration
	 * 
	 * @param numeric $limit Number of candidates to find
	 * @return array
	 */
	public function getFetchCandidates($limit = 10) {
		$result = array();

		$result = $this->find('list', array(
			'order' => 'last_fetch_attempt DESC',
			'limit' => $limit,
			'recursive' => -1,
			'fields' => 'url',
		));

		return $result;
	}
}
