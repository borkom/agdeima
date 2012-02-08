<?php
App::uses('AppController', 'Controller');
/**
 * Categories Controller
 *
 * @property Category $Category
 */
class CategoriesController extends AppController {
		
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->layout = 'admin';			
		$this->Category->recursive = 0;
		$this->set('categories', $this->paginate());
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		$this->layout = 'admin';			
		if ($this->request->is('post')) {
			$this->Category->create();
			if ($this->Category->save($this->request->data)) {
				$this->Session->setFlash(__('Nova kategorija je uneta'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Kategorija nije unesena.'));
			}
		}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->layout = 'admin';			
		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__('Nepostojeca kategorija'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Category->save($this->request->data)) {
				$this->Session->setFlash(__('Kategorija je izmenjena'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Kategorija nije izmenjena, pokusajte ponovo.'));
			}
		} else {
			$this->request->data = $this->Category->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__('Nepostojeca kategorija'));
		}
		if ($this->Category->delete()) {
			$this->Session->setFlash(__('Kategorija je obrisana'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Kategorija nije obrisana'));
		$this->redirect(array('action' => 'index'));
	}
}
