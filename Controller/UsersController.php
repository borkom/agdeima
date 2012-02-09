<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {
    public $components = array('RequestHandler', 'MathCaptcha', array('timer' => 3));
	public $helpers = array('Js');
	public $uses = array('User');
	
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('validate_form', 'contact', 'newsunsub');
	}
	
	function beforeRender()
	{
		parent::beforeRender();
	} 		

/**
 * contact method
 *
 * @return void
 */
	public function contact() {			
		if($this->request->is('post')){
			if($this->MathCaptcha->validate($this->request->data['Contact']['captcha'])){
					$email = new CakeEmail();
					$email->config('smtp');
					$email->template('contact', 'agdeima');
					$email->to('gojnik@gmail.com');
					$email->from($this->request->data['Contact']['email']);
					$email->subject('Kontakt preko sajta - '.$this->request->data['Contact']['subject']);
					$email->viewVars(array('name' => $this->request->data['Contact']['name'], 'text' => $this->request->data['Contact']['content'], 'email' => $this->request->data['Contact']['email']));
					$email->emailFormat('html');
					if($email->send()){
						$this->Session->setFlash('Poruka je uspesno poslata, javicemo Vam se uskoro.');
						unset($this->request->data);				
					}				
			} else {
				//$this->set('contact', $this->request->data);
				$this->Session->setFlash('Pogresan rezultat za captcha, pokusajte ponovo.');
			}			
		}
		
		$this->set('captcha', $this->MathCaptcha->getCaptcha());
	}

/**
 * admin_login method
 *
 * @return void
 */
	public function admin_login() {
		//$this->layout = 'admin';			
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
 * admin_newsletter method
 *
 * @param string $id
 * @return void
 */
	public function admin_newsletter() {
		$this->layout = 'admin';
		if($this->request->is('post')){

					$email = new CakeEmail();
					$email->config('smtp');
					$email->template('newsletter', 'agdeima');
					$email->bcc($this->User->find('list', array('fields' => array('User.id', 'User.email'), 'conditions' => array('User.newsletter' => true), 'recursive' => 0)));
					$email->subject($this->request->data['Newsletter']['subject']);
					$email->viewVars(array('text' => $this->request->data['Newsletter']['content']));
					$email->emailFormat('html');
					if($email->send()){
						$this->Session->setFlash('Newsletter je uspesno poslat!');
						unset($this->request->data);				
					}						
		}
	}

/**
 * newsunsub method
 *
 * @return void
 */
	public function newsunsub() {
		if ($this->request->is('post')) {
			$user_id = $this->User->field('id', array('User.email =' => $this->request->data['User']['email']));	
			if($this->User->updateAll(array('User.newsletter' => "\"".false."\""), array('User.id =' => $user_id))){
			$this->Session->setFlash(__('Uspesna odjava prijema novosti.'));
			$this->redirect(array('controller' => 'posts', 'action' => 'index'));
			}
		}
		
		if($this->Session->check('Login.email')){
			if($this->User->updateAll(array('User.newsletter' => "\"".false."\""), array('User.id =' => $this->Session->read('Login.id')))){
			$this->Session->setFlash(__('Uspesna odjava prijema novosti.'));
			$this->redirect(array('controller' => 'posts', 'action' => 'index'));
			}
		}
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
