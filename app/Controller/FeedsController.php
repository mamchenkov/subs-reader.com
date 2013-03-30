<?php
App::uses('AppController', 'Controller');
/**
 * Feeds Controller
 *
 * @property Feed $Feed
 */
class FeedsController extends AppController {

	/**
	 * View feed
	 * 
	 * @param numeric $id Feed id
	 * @return void
	 */
	public function view($id = null) {
		
		if (!$this->Feed->exists($id)) {
			throw new NotFoundException("You are not subscribed to this feed");
		}

		$user = AuthComponent::user();
		if (!$this->Feed->isUserSubscribed($user['id'], $id)) {
			throw new NotFoundException("You are not subscribed to this feed");
		}

		$feed = $this->Feed->findById($id);
		$this->set('feed', $feed);
		
		$posts = $this->Feed->getUserPosts($user['id'], $id);
		$this->set('posts', $posts);
	}
}
