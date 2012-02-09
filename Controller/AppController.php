<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 */
class AppController extends Controller {
	public $components = array(
		'Session',
		'Auth' => array(
			'loginRedirect' => array('controller' => 'posts', 'action' => 'index', 'admin' => true),
			'logoutRedirect' => array('controller' => 'posts', 'action' => 'index', 'admin' => false),		
			'authError' => "Nemate pristup ovoj stranici!",
			'authorize' => array('Controller')
		)
	);

	public $uses = array('Post', 'Comment', 'User', 'Page');	
	public $helpers = array('Time', 'Html', 'Session', 'Form');
	
	public function isAuthorized($user){
		return true;
	}
	
	public function beforeFilter(){
		//$this->Auth->allow('index', 'view');
	}
	
	public function beforeRender()
	{
		//header links to static pages	
		$this->Page->recursive = 0;
		$links = $this->Page->find('all');
		$this->set('links', $links);		
		
		//most viewed posts	
		$this->Post->recursive = 0;
		$mostViewed = $this->Post->find('all', array('conditions' => array('Post.published =' => true), 'fields' => array('Post.id', 'Post.title', 'Post.permalink', 'Post.created'), 'limit' => 4, 'order' => 'Post.view_count DESC'));
		$this->set('mostViewed', $mostViewed);
		
		//categories with most posts
		$popularcat = $this->Post->query(' SELECT Category.name,Category.permalink,Category.id, COUNT(ABS(p.category_id)) AS count
 FROM categories Category,posts p
 WHERE p.category_id=Category.id
 AND p.published=true
 GROUP BY Category.name 
 ORDER BY SUM(ABS(p.category_id)) DESC LIMIT 4;
		');
		$this->set('popularcat', $popularcat);
		
		//user stats
		if($this->Session->check('Login.id')){
			$userstats = array();
			$userstats['postscount'] = $this->Post->find('count', array('conditions' => array('Post.user_id' => $this->Session->read('Login.id'))));
			$userstats['votes'] = $this->Comment->query(' SELECT SUM(Comment.up) AS votes_up, SUM(Comment.down) AS votes_down
			FROM comments Comment
			WHERE Comment.user_id = '.$this->Session->read('Login.id').'
			GROUP BY Comment.user_id
			');
			$this->User->recursive = 0;
			$userstats['info'] = $this->User->find('first', array('conditions' => array('User.id' => $this->Session->read('Login.id')), 'fields' => array('User.created', 'User.username')));
			//$userstats['downvotes']
			$this->set('userstats', $userstats);
		}
	}
}
