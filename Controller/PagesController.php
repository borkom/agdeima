<?php
class PagesController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Pages';
	
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('view');
	}
	
	function beforeRender()
	{
		parent::beforeRender();
	}
	
/**
 * Default helper
 *
 * @var array
 */
	public $helpers = array('Html');


	public $uses = array('Page');

/**
 * view method
 *
 * @return void
 */
	public function view($permalink = null, $id = null) {			
		$this->Page->id = $id;
		if (!$this->Page->exists()) {
			throw new NotFoundException(__('Invalid page'));
		} else {
			$this->set('page', $this->Page->findById($id));
		}
	}
	
/**
 * admin_view method
 *
 * @return void
 */
	public function admin_view($id = null) {
		$this->layout = 'admin';			
		if ($this->request->is('post')) {
			$this->Page->create();
			if ($this->Page->save($this->request->data)) {
				$this->Session->setFlash(__('Nova strana je uneta'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Strana nije unesena.'));
			}
		}
	}	

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->layout = 'admin';			
		$this->Page->recursive = 0;
		$this->set('pages', $this->paginate());
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		$this->layout = 'admin';			
		if ($this->request->is('post')) {
			$this->Page->create();
			if ($this->Page->save($this->request->data)) {
				$this->Session->setFlash(__('Nova strana je uneta'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Strana nije unesena.'));
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
		$this->Page->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__('Nepostojeca stranaa'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Page->save($this->request->data)) {
				$this->Session->setFlash(__('Strana je izmenjena'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Strana nije izmenjena, pokusajte ponovo.'));
			}
		} else {
			$this->request->data = $this->Page->read(null, $id);
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
		$this->Page->id = $id;
		if (!$this->Page->exists()) {
			throw new NotFoundException(__('Nepostojeca strana'));
		}
		if ($this->Page->delete()) {
			$this->Session->setFlash(__('Strana je obrisana'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Strana nije obrisana'));
		$this->redirect(array('action' => 'index'));
	}
}	
?>
