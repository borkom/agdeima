<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
//set_include_path('/var/www/ZendGdata/library/');
//App::import('Vendor', 'upload');
/**
 * Posts Controller
 *
 * @property Post $Post
 */
class PostsController extends AppController {
    public $components = array('RequestHandler' ,'Picasa', 'PermalinkGenerator', 'MathCaptcha', array('timer' => 3));
	public $helpers = array('Js', 'Session', 'Time', 'Text');
	public $uses = array('User', 'Post', 'Comment', 'Category');
	
	
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('index', 'view', 'add', 'unsubscribe', 'search', 'validate_form', 'categorized');
	}
	
	function beforeRender()
	{
		$this->Post->recursive = 0;
		$mostViewed = $this->Post->find('all', array('conditions' => array('Post.published =' => true), 'fields' => array('Post.id', 'Post.title', 'Post.permalink', 'Post.created'), 'limit' => 4, 'order' => 'Post.view_count DESC'));
		$this->set('mostViewed', $mostViewed);
	}
	
/**
 * index method
 *
 * @return void
 */
	public function index() {
    	if ($this->RequestHandler->isRss() ) {
        	$posts = $this->Post->find('all', array('conditions' => array('Post.published =' => true), 'limit' => 20, 'order' => 'Post.created DESC'));
        return $this->set(compact('posts'));
    	}
					
		$this->Post->recursive = 1;
		$this->paginate = array('limit' => 5, 'conditions' => array('Post.published =' => true), 'order' => array('Post.created' => 'desc'));		
		$data = $this->paginate('Post');
		$this->set('posts', $data);
	}
	
/**
 * categorized method
 *
 * @param string $id
 * @return void
 */
	public function categorized($permalink = null, $id = null) {
					
		$this->Post->recursive = 1;
		$this->paginate = array('limit' => 5, 'conditions' => array('Post.published =' => true, 'Post.category_id' => $id), 'order' => array('Post.created' => 'desc'));		
		$data = $this->paginate('Post');
		$this->set('posts', $data);
	}	

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($year = null, $month = null, $permalink = null, $id = null) {
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
					$email->viewVars(array('id' => $id, 'title' => $this->Post->field('title', array('Post.id' => $id)), 'permalink' => $this->Post->field('permalink', array('Post.id' => $id)), 'created' => $this->Post->field('created', array('Post.id' => $id))));
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
		$comments = $this->Post->Comment->find('all', array('fields' => array('User.username', 'Comment.id', 'Comment.content', 'Comment.created', 'Comment.up', 'Comment.down'), 'conditions' => array('Post.id' => $id)));
		$post = $this->Post->read(null, $id);
		$this->set('post', $post);
		$this->set('comments', $comments);
		$this->set('captcha', $this->MathCaptcha->getCaptcha());
		$this->set('params', $this->request->params);
		$this->set('neighbors', $this->Post->find('neighbors', array('field' => 'id', 'value' => $id)));
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
				$file = $this->request->data['Upload']['file'];					
				if($file['error'] == 0){
					$this->Post->Image->create();
					$url = $this->Picasa->getImageUrl($file['name'], $file['tmp_name'], $file['type']);
					$this->Post->Image->set('post_id', $this->Post->id);
					$this->Post->Image->set('location', $url['location']);
					$this->Post->Image->set('thumbnail', $url['thumbnail']);
					$this->Post->Image->set('width', $url['width']);
					$this->Post->Image->set('height', $url['height']);										
					$this->Post->Image->save();															
				}
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
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
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
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->layout = 'admin';					
		$this->Post->recursive = 1;
		$this->paginate = array('limit' => 10, 'order' => array('Post.created' => 'desc'));		
		$data = $this->paginate('Post');
		$this->set('posts', $data);
	}
	
/**
 * admin_categorized method
 *
 * @param string $id
 * @return void
 */
	public function admin_categorized($id = null) {
		$this->layout = 'admin';					
		$this->Post->recursive = 1;
		$this->paginate = array('limit' => 10, 'conditions' => array('Post.category_id' => $id), 'order' => array('Post.created' => 'desc'));		
		$data = $this->paginate('Post');
		$this->set('posts', $data);
	}	
	
/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->layout = 'admin';	
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException(__('Invalid post'));
		}
		$comments = $this->Post->Comment->find('all', array('fields' => array('User.username', 'Comment.id', 'Comment.content', 'Comment.created', 'Comment.up', 'Comment.down'), 'conditions' => array('Post.id' => $id)));
		$post = $this->Post->read(null, $id);
		$this->set('post', $post);
		$this->set('comments', $comments);
		$this->set('neighbors', $this->Post->find('neighbors', array('field' => 'id', 'value' => $id)));
	}		
	
/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->layout = 'admin';			
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException(__('Invalid post'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash(__('Post je izmenjen'));
				$this->redirect(array('controller' => 'posts', 'action' => 'view', $id));
			} else {
				$this->Session->setFlash(__('Post nije izmenjen, pokusajte ponovo.'));
			}
		} else {
			$this->request->data = $this->Post->read(null, $id);
		}
		//$users = $this->Post->User->find('list');
		$categories = $this->Post->Category->find('list');
		$this->set(compact('categories'));
	}
	
/**
 * admin_publish method
 *
 * @param string $id
 * @return void
 */
	public function admin_publish($id = null) {
		$this->layout = 'admin';			
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException(__('Invalid post'));
		} else {
			$this->Post->set('published', true);
			if($this->Post->save()){
				$this->Session->setFlash(__('Post objavljen'));
				$this->redirect(array('controller' => 'posts', 'action' => 'view', $id));
			}
			
		}
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
	
/**
 * search method
 *
 * @return void
 */
	public function search() {
					
		$this->Post->recursive = 1;
		$this->paginate = array('limit' => 5, 'conditions' => array('Post.published =' => true), 'order' => array('Post.created' => 'desc'));		
		$data = $this->paginate('Post');
		$this->set('posts', $data);
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
			$this->Post->set($this->request->data['field'], $this->request->data['value']);
			if($this->Post->validates()){
				$this->autoRender = false;
			} else {
				$error = $this->validateErrors($this->Post);
				$this->set('error', $error[$this->request->data['field']][0]);
			}
		}
	} 		
}
