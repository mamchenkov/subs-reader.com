<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

	/**
	 * Login
	 * 
	 * @return void
	 */
	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirectUrl());
			}
			else {
				$this->Session->setFlash(__('Username or password is incorrect'));
				return $this->redirect('/');
			}
		}
	}

	/**
	 * Logout
	 * 
	 * @return void
	 */
	public function logout() {
		$this->redirect($this->Auth->logout());
	}
	
	/**
	 * Register
	 *
	 * @return void
	 */
	public function register() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('Your account has been created.  Please login now.'));
				$this->redirect('/');
			} else {
				$this->Session->setFlash(__('Registration failed. Please, try again.'));
			}
		}
	}

	/**
	 * Home
	 * 
	 * @return void
	 */
	public function home() {
	}

	/**
	 * Get feeds
	 * 
	 * @return void
	 */
	public function get_feeds() {

		$this->layout  = 'ajax';
	
		$feeds = array();
		$user = AuthComponent::user();
		if (!empty($user)) {
			$feeds = $this->User->getFeeds($user['id']);
		}

		$this->set('feeds', $feeds);
	}

}
