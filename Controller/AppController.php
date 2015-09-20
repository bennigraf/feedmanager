<?php
App::uses('Controller', 'Controller');
class AppController extends Controller {
	var $components = array('Session', 'Auth' => array('authenticate' => array('Form')));
	
	function beforeFilter() {
		$this->disableCache();
	}
}

?>