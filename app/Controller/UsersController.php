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
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$feeds = $this->User->Feed->find('list');
		$posts = $this->User->Post->find('list');
		$this->set(compact('feeds', 'posts'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
