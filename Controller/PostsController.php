<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Posts Controller
 *
 * @property Post $Post
 */
class PostsController extends AppController {
    public $components = array('Session', 'PermalinkGenerator', 'MathCaptcha', array('timer' => 3));
	public $helpers = array('Session');
	public $uses = array('User', 'Post', 'Comment');
	
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
		if($this->request->is('post')){
			if($this->MathCaptcha->validate($this->request->data['Post']['captcha'])){
				$this->User->create();
				if($this->Session->check('Login.email')){
					$this->request->data['User']['email'] = $this->Session->read('Login.email');
					$this->request->data['User']['username'] = $this->Session->read('Login.username');
				}				
				if($this->User->save($this->request->data)){
					$user_id = $this->User->id;
				} else {
					$username = "\"".$this->request->data['User']['username']."\"";
					$this->User->id = $this->User->field('id', array('User.email =' => $this->request->data['User']['email']));
					if($this->User->updateAll(array('User.username' => $username), array('User.email =' => $this->request->data['User']['email']))){
						$user_id = $this->User->id;
					} else {
					$this->Session->setFlash(__('emailThe post could not be saved. Please, try again.'));
					}					
				}
				$this->Comment->create();
				$this->Comment->set('content', $this->request->data['Comment']['content']);
				$this->Comment->set('user_id', $user_id);
				$this->Comment->set('post_id', $id);
				if($this->Comment->save()){
					$this->Session->write('Login.email', $this->request->data['User']['email']);
					$this->Session->write('Login.username', $this->request->data['User']['username']);
					$this->Session->write('Login.id', $user_id);										
					/*$email = new CakeEmail();
					$email->config('smtp');
					$email->template('notify', 'agdeima');
					$email->to('admin@agdeima.com');
					$email->bcc($this->Post->PostUser->find('list', array('fields' => array('User.id', 'User.email'), 'conditions' => array('PostUser.post_id' => $id, 'PostUser.notify' => true), 'recursive' => 0)));
					$email->subject('Novi komentar');
					$email->viewVars(array('id' => $id, 'title' => $this->Post->field('title', array('Post.id' => $id))));
					$email->emailFormat('html');
					$email->send();*/
					$postuser = $this->Post->PostUser->find('first', array('conditions' => array('PostUser.post_id' => $id, 'PostUser.user_id' => $user_id)));	
					if(empty($postuser)){	
					$this->Post->PostUser->create();
					$this->Post->PostUser->set('post_id', $id);
					$this->Post->PostUser->set('user_id', $user_id);
					$this->Post->PostUser->set('notify', $this->request->data['PostUser']['notify']);
					$this->Post->PostUser->save();
					}	
					$this->Session->setFlash(__('Komentar je objavljen'));
					$this->redirect(array('action' => 'view', $id));
					//unset($this->request->data);					
				} else {
					$this->Session->setFlash(__('Greska prilikom slanja komentara'));					
				}											
			} else {
				$this->Session->setFlash('Pogresan rezultat za captcha. Pokusajte ponovo.');				
			}			
		}
		//$this->Post->Comment->recursive = 1;	
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException(__('Invalid post'));
		}
		$comments = $this->Post->Comment->find('all', array('fields' => array('User.username', 'Comment.content', 'Comment.created'), 'conditions' => array('Post.id' => $id)));
		$post = $this->Post->read(null, $id);
		$this->set('post', $post);
		$this->set('comments', $comments);
		$this->set('captcha', $this->MathCaptcha->getCaptcha());
		//$this->set('usernotify', $this->Post->PostUser->find('list', array('fields' => array('User.id', 'User.email'), 'conditions' => array('PostUser.post_id' => $id, 'PostUser.notify' => true), 'recursive' => 0)));
		// session based view counter
		if(is_numeric($post['Post']['id'])){
                if(!$this->Session->check('Viewed.'.$id)){
                    $this->Session->write('Viewed.'.$id, true);
                    $view_count = $post['Post']['view_count'] + 1;
                    $this->Post->saveField('view_count', $view_count);
                }
                }
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
		if($this->MathCaptcha->validate($this->request->data['Post']['captcha'])){	
		if ($this->request->is('post')) {
			$this->User->create();
			if($this->Session->check('Login.email')){
				$this->request->data['User']['email'] = $this->Session->read('Login.email');
				$this->request->data['User']['username'] = $this->Session->read('Login.username');
			}
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
			$this->Post->set('permalink', $this->PermalinkGenerator->toAscii(($this->request->data['Post']['title'])));
			if ($this->Post->save($this->request->data)) {
				$this->Session->write('Login.email', $this->request->data['User']['email']);
				$this->Session->write('Login.username', $this->request->data['User']['username']);
				$this->Session->write('Login.id', $user_id);								
				/*$email = new CakeEmail();
				$email->config('smtp');
				$email->template('default', 'default');
				$email->to('admin@agdeima.com');
				$email->subject('Novi post');
				$email->emailFormat('html');
				$email->send();*/					
				$this->Post->PostUser->create();
				$this->Post->PostUser->set('post_id', $this->Post->id);
				$this->Post->PostUser->set('user_id', $user_id);
				$this->Post->PostUser->set('notify', $this->request->data['PostUser']['notify']);
				$this->Post->PostUser->save();	
				$this->Session->setFlash(__('The post has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The post could not be saved. Please, try again.'));
			}
		}
		} else {
			$this->Session->setFlash('Pogresan rezultat za captcha. Pokusajte ponovo.');
		}
		}
		
		//$users = $this->Post->User->find('list');
		$categories = $this->Post->Category->find('list');
		$this->set(compact('categories'));
    	$this->set('captcha', $this->MathCaptcha->getCaptcha());
    	$this->set('captcha_result', $this->MathCaptcha->getResult());
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
	
/**
 * unsubscribe method
 *
 * @param string $id
 * @return void
 */
	public function unsubscribe($id = null) {
		if ($this->request->is('post')) {
			$user_id = $this->User->field('id', array('User.email =' => $this->request->data['User']['email']));	
			if($this->Post->PostUser->updateAll(array('PostUser.notify' => "\"".false."\""), array('PostUser.user_id =' => $user_id, 'PostUser.post_id =' => $id))){
			$this->Session->setFlash(__('Uspesna odjava'));
			$this->redirect(array('action' => 'index'));
			}
		}
		
		if($this->Session->check('Login.email')){
			if($this->Post->PostUser->updateAll(array('PostUser.notify' => "\"".false."\""), array('PostUser.user_id =' => $this->Session->read('Login.id'), 'PostUser.post_id =' => $id))){
			$this->Session->setFlash(__('Uspesna odjava'));
			$this->redirect(array('action' => 'index'));
			}
		}
	}	
}
