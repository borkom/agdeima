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
	
	public function isAuthorized($user){
		return true;
	}
	
	public function beforeFilter(){
		//$this->Auth->allow('index', 'view');
	}
}
