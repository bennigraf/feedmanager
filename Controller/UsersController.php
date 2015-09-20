<?php
class UsersController extends AppController {

    var $name = 'Users';
 
    /**
     *  The AuthComponent provides the needed functionality
     *  for login, so you can leave this function blank.
     */
    function login() {
	    if ($this->request->is('post')) {
	        if ($this->Auth->login()) {
	            return $this->redirect($this->Auth->redirect());
	        } else {
	            $this->Session->setFlash(__('Username or password is incorrect'), 'default', array(), 'auth');
	        }
	    }
    }

    function logout() {
        $this->redirect($this->Auth->logout());
    }
}
?>