<?php
App::uses('AppController', 'Controller');
/**
 * Comments Controller
 *
 * @property Comment $Comment
 */
class CommentsController extends AppController {

/**
 * voteup method
 *
 * @return void
 */
	public function voteup($id = null) {
		if(isset($id)){
			$this->Comment->id = $id;
			if(!$this->Comment->exists()){
				$this->Session->setFlash('Nepostojeci komentar.');
				$this->redirect(array('controller' => 'posts', 'action' => 'index'));
			} else {
				$comment = $this->Comment->read('up', $id);
				if($this->Comment->Vote->find('first', array('conditions' => array('Vote.comment_id' => $id, 'Vote.ip =' => $_SERVER['REMOTE_ADDR'])))){
					//vec ste glasali
					$this->Session->setFlash('Vec ste glasali.');
					$this->redirect(array('controller' => 'posts', 'action' => 'index'));
				} else {
					//povecati glas
                    $vote_count = $comment['Comment']['up'] + 1;
                    $this->Comment->set('up', $vote_count);						
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

/**
 * votedown method
 *
 * @return void
 */
	public function votedown($id = null) {
		if(isset($id)){
			$this->Comment->id = $id;
			if(!$this->Comment->exists()){
				$this->Session->setFlash('Nepostojeci komentar.');
				$this->redirect(array('controller' => 'posts', 'action' => 'index'));
			} else {
				$comment = $this->Comment->read('down', $id);
				if($this->Comment->Vote->find('first', array('conditions' => array('Vote.comment_id' => $id, 'Vote.ip =' => $_SERVER['REMOTE_ADDR'])))){
					//vec ste glasali
					$this->Session->setFlash('Vec ste glasali.');
					$this->redirect(array('controller' => 'posts', 'action' => 'index'));
				} else {
					//povecati glas
                    $vote_count = $comment['Comment']['down'] + 1;
                    $this->Comment->set('down', $vote_count);						
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
		
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Comment->recursive = 0;
		$this->set('comments', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
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
	public function add() {
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
	public function edit($id = null) {
		$this->Comment->id = $id;
		if (!$this->Comment->exists()) {
			throw new NotFoundException(__('Invalid comment'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Comment->save($this->request->data)) {
				$this->Session->setFlash(__('The comment has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The comment could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Comment->read(null, $id);
		}
		$users = $this->Comment->User->find('list');
		$posts = $this->Comment->Post->find('list');
		$this->set(compact('users', 'posts'));
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
		$this->Comment->id = $id;
		if (!$this->Comment->exists()) {
			throw new NotFoundException(__('Invalid comment'));
		}
		if ($this->Comment->delete()) {
			$this->Session->setFlash(__('Comment deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Comment was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
