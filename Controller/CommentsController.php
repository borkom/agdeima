<?php
App::uses('AppController', 'Controller');
/**
 * Comments Controller
 *
 * @property Comment $Comment
 */
class CommentsController extends AppController {
    public $components = array('RequestHandler');
	public $helpers = array('Js');
	
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('vote');
	}	
	
/**
 * vote method
 *
 * @param string $direction
 * @param string $id
 * @return void
 */
	public function vote($direction = null, $id = null) {
		if ($this->request->is('ajax')) {
			$this->disableCache();
		if(isset($id) && isset($direction)){
			$this->Comment->id = $id;
			if($this->Comment->exists()){
				$comment = $this->Comment->read($direction, $id);
				if($this->Comment->Vote->find('first', array('conditions' => array('Vote.comment_id' => $id, 'Vote.ip =' => $_SERVER['REMOTE_ADDR'])))){
					//vec ste glasali
					$this->set('error', 'Već ste glasali na ovaj komentar!');
				} else {
					//povecati glas
                    $vote_count = $comment['Comment'][$direction] + 1;
                    $this->Comment->set($direction, $vote_count);						
                    if($this->Comment->save()){
						$this->Comment->Vote->create();
						$this->Comment->Vote->set('comment_id', $this->Comment->id);
						$this->Comment->Vote->set('ip', $_SERVER['REMOTE_ADDR']);
						$this->Comment->Vote->save();
						$this->set('error', $vote_count);                    	
                    }					
				}				
			
				
				}
		}
			
		} else {			
			
		if(isset($id) && isset($direction)){
			$this->Comment->id = $id;
			if(!$this->Comment->exists()){
				$this->Session->setFlash('Nepostojeci komentar.');
				$this->redirect(array('controller' => 'posts', 'action' => 'index'));
			} else {
				$comment = $this->Comment->read($direction, $id);
				if($this->Comment->Vote->find('first', array('conditions' => array('Vote.comment_id' => $id, 'Vote.ip =' => $_SERVER['REMOTE_ADDR'])))){
					//vec ste glasali
					$this->Session->setFlash('Vec ste glasali.');
					$this->redirect(array('controller' => 'posts', 'action' => 'index'));
				} else {
					//povecati glas
                    $vote_count = $comment['Comment'][$direction] + 1;
                    $this->Comment->set($direction, $vote_count);						
                    if($this->Comment->save()){
						$this->Comment->Vote->create();
						$this->Comment->Vote->set('comment_id', $this->Comment->id);
						$this->Comment->Vote->set('ip', $_SERVER['REMOTE_ADDR']);
						$this->Comment->Vote->save();
						$this->Session->setFlash('Hvala Vam za glasanje.');
						$this->redirect(array('controller' => 'posts', 'action' => 'index'));						                    	
                    }					
				}				
			}
				

		} else {
			$this->Session->setFlash('Nije setovan id komentara.');
			$this->redirect(array('controller' => 'posts', 'action' => 'index'));
		}
	}	
	}
		
/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$this->layout = 'admin';			
		$this->Comment->recursive = 0;
		$this->set('comments', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->layout = 'admin';			
		$this->Comment->id = $id;
		if (!$this->Comment->exists()) {
			throw new NotFoundException(__('Invalid comment'));
		}
		$this->set('comment', $this->Comment->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		$this->layout = 'admin';			
		if ($this->request->is('post')) {
			$this->Comment->create();
			if ($this->Comment->save($this->request->data)) {
				$this->Session->setFlash(__('The comment has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The comment could not be saved. Please, try again.'));
			}
		}
		$users = $this->Comment->User->find('list');
		$posts = $this->Comment->Post->find('list');
		$this->set(compact('users', 'posts'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null, $id_post = null) {
		$this->layout = 'admin';			
		$this->Comment->id = $id;
		if (!$this->Comment->exists()) {
			throw new NotFoundException(__('Invalid comment'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Comment->save($this->request->data)) {
				$this->Session->setFlash(__('Komentar izmenjen'));
				$this->redirect(array('controller' => 'posts', 'action' => 'view', $id_post));
			} else {
				$this->Session->setFlash(__('Komentar nije izmenjen, pokusajte ponovo.'));
			}
		} else {
			$this->request->data = $this->Comment->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null, $id_post = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Comment->id = $id;
		if (!$this->Comment->exists()) {
			throw new NotFoundException(__('Nepostojeci komentar'));
		}
		if ($this->Comment->delete()) {
			$this->Session->setFlash(__('Komentar izbrisan.'));
			$this->redirect(array('controller' => 'posts', 'action' => 'view', $id_post));
		}
		$this->Session->setFlash(__('Komentar nije izbrisan'));
		$this->redirect(array('controller' => 'posts', 'action' => 'view', $id_post));
	}
	
/**
 * admin_publish method
 *
 * @param string $id
 * @return void
 */
	public function admin_publish($id = null, $id_post = null) {
		$this->layout = 'admin';			
		$this->Comment->id = $id;
		if (!$this->Comment->exists()) {
			throw new NotFoundException(__('Nepostojeci komentar'));
		} else {
			$this->Comment->set('published', true);
			if($this->Comment->save()){
				$this->Session->setFlash(__('Komentar objavljen'));
				$this->redirect(array('controller' => 'posts', 'action' => 'view', $id_post));
			}
			
		}
	}	
}
