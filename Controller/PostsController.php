<?php
App::uses('AppController', 'Controller');
/**
 * Posts Controller
 *
 * @property Post $Post
 */
class PostsController extends AppController {
    public $components = array('MathCaptcha', array('timer' => 3));
	public $helpers = array('Session');
	public $uses = array('User', 'Post');
	
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Post->recursive = 1;
		$this->paginate = array('limit' => 5, 'order' => array('Post.created' => 'desc'));		
		$data = $this->paginate('Post');
		$this->set('posts', $data);
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {

		//$this->Post->Comment->recursive = 1;	
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException(__('Invalid post'));
		}
		$comments = $this->Post->Comment->find('all', array('fields' => array('User.username', 'Comment.content', 'Comment.created'), 'conditions' => array('Post.id' => $id)));
		$this->set('post', $this->Post->read(null, $id));
		$this->set('comments', $comments);
		$this->set('captcha', $this->MathCaptcha->getCaptcha());
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
			
		if ($this->request->is('post')) {
			$this->User->create();
			if($this->User->save($this->request->data)){
				$user_id = $this->User->id;
			} else {
				//$this->User->recursive = 1;
				//$usertemp = $this->User->find('first', array('fields' => 'User.id', 'conditions' => array('User.email =' => $this->request->data['User']['email'])));	
				//$this->User->id = $usertemp['User']['id'];
				$username = "\"".$this->request->data['User']['username']."\"";
				//$this->User->set('username', $this->request->data['User']['username']);
				$this->User->id = $this->User->field('id', array('User.email =' => $this->request->data['User']['email']));
				if($this->User->updateAll(array('User.username' => $username), array('User.email =' => $this->request->data['User']['email']))){
					$user_id = $this->User->id;
				} else {
					$this->Session->setFlash(__('emailThe post could not be saved. Please, try again.'));
				}
			}
			//$this->User->unbindModel(array('hasMany' => array('Post'))); 		
			//unset($this->request->data['User']);
			$this->Post->recursive = 1;
			$this->Post->create();
			$this->Post->set('user_id', $user_id);
			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash(__('The post has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The post could not be saved. Please, try again.'));
			}
		}
		
		//$users = $this->Post->User->find('list');
		$categories = $this->Post->Category->find('list');
		$this->set(compact('categories'));
		$this->set('captcha', $this->MathCaptcha->getCaptcha());
		$this->set('unos', $this->request->data);
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException(__('Invalid post'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash(__('The post has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The post could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Post->read(null, $id);
		}
		$users = $this->Post->User->find('list');
		$categories = $this->Post->Category->find('list');
		$this->set(compact('users', 'categories'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException(__('Invalid post'));
		}
		if ($this->Post->delete()) {
			$this->Session->setFlash(__('Post deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Post was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
