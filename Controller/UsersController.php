<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {
    public $components = array('RequestHandler');
	public $helpers = array('Js');
	public $uses = array('User');
	
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('validate_form');
	}	

/**
 * admin_login method
 *
 * @return void
 */
	public function admin_login() {
		$this->layout = 'admin';			
		if($this->request->is('post')){
			if($this->Auth->login()){
				$this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash('Netacna kombinacija korisnickog imena i lozinke!');
			}
		}
	}
	
/**
 * admin_logout method
 *
 * @return void
 */
	public function admin_logout() {
		$this->redirect($this->Auth->logout());
	}	

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->layout = 'admin';			
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->layout = 'admin';			
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		$this->layout = 'admin';			
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->layout = 'admin';			
		$this->User->id = $id;
		if (!$this->User->exists()) {
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
			$this->request->data = $this->User->read(null, $id);
		}
	}

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
/**
 * validate_form method
 *
 * @return void
 */

	public function validate_form(){
		if ($this->request->is('ajax')) {
			$this->disableCache();
			//$this->request->data['field'] = $this->request->data['value'];
			$this->User->set($this->request->data['field'], $this->request->data['value']);
			if($this->User->validates()){
				$this->autoRender = false;
			} else {
				$error = $this->validateErrors($this->User);
				$this->set('error', $error[$this->request->data['field']][0]);
			}
		}
	}	
}
