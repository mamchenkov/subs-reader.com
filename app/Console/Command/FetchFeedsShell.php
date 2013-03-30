<?php
/**
 * Fetch feeds
 */

App::import('Vendor', 'SimplePie/autoloader');

class FetchFeedsShell extends AppShell {

	/**
	 * Feeds to fetch
	 */
	public $limit = 10;

	/**
	 * Feed fetching log
	 */
	public $log = 'fetch';
	
	/**
	 * Default entry point
	 */
	public function main() {
		$this->log("Feed fetcher started", $this->log);
		
		$feed = ClassRegistry::init('Feed');
		$candidates = $feed->getFetchCandidates($this->limit);
		
		$this->log("Found " . count($candidates) . " feeds to fetch", $this->log);
		$this->fetchCandidates($candidates);

		$this->log("Feed fetcher finished", $this->log);
	}

	/**
	 * Fetch candidate feeds 
	 * 
	 * @param array $candidates List of feeds with IDs and URLs
	 * @return void
	 */
	public function fetchCandidates($candidates) {

		foreach ($candidates as $feedId => $feedUrl) {
			
			$feed = ClassRegistry::init('Feed');
			$now = date('Y-m-d H:i:s');
		
			$fetcher = new SimplePie();
			$fetcher->enable_cache(true);
			$fetcher->set_cache_location('/tmp/');
			$fetcher->set_feed_url($feedUrl);
			$success = $fetcher->init();

			if ($success) {
			
				$feedUpdate = array();
				$feedUpdate['Feed'] = array();
				$feedUpdate['Feed']['id'] = $feedId; 
				$feedUpdate['Feed']['title'] = $fetcher->get_title();
				$feedUpdate['Feed']['link'] = $fetcher->get_link();
				$feedUpdate['Feed']['last_fetch_attempt'] = $now;
				$feedUpdate['Feed']['last_fetch_success'] = $now;
				$feed->create();
				$feed->save($feedUpdate);
			
				foreach ($fetcher->get_items() as $item) {
					$post = ClassRegistry::init('Post');

					$postUpdate = array();
					$postUpdate['Post'] = array();
					$postUpdate['Post']['feed_id'] = $feedId;
					$postUpdate['Post']['url'] = $item->get_permalink();
					$postUpdate['Post']['title'] = $item->get_title();
					$postUpdate['Post']['guid'] = $item->get_id();
					$postUpdate['Post']['author'] = $item->get_author()->get_name();
					$postUpdate['Post']['published'] = $item->get_date();
					$postUpdate['Post']['content'] = $item->get_content();
					
					$post->create();
					$post->save($postUpdate);
				}
				
				$this->log("Fetched " . $fetcher->get_item_quantity() . " items from $feedUrl", $this->log);
			}
			else {
				$feedUpdate = array();
				$feedUpdate['Feed'] = array();
				$feedUpdate['Feed']['id'] = $feedId; 
				$feedUpdate['Feed']['last_fetch_attempt'] = $now;
				$feed->create();
				$feed->save($feedUpdate);

				$this->log("Failed to fetch $feedUrl : " . $fetcher->error(), $this->log);
			}
		}
	}
	
}	
