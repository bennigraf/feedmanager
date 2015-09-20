<?php  
class UsersShell extends Shell { 
var $uses = array('User'); 

function main() { 
	
}

function newpassword() {
	App::import('Component', 'Auth');
	$this->Auth = new AuthComponent;
	
	$this->out('Set password for user:');
	$this->hr();
	
	while (empty($username)) { 
		$username = $this->in('Username: '); 
		if (empty($username)) $this->out('Username must not be empty!'); 
	}
	while (empty($pwd1)) { 
		$pwd1 = $this->in('New password:'); 
		if (empty($pwd1)) $this->out('Password must not be empty!'); 
	}
	while (empty($pwd2)) { 
		$pwd2 = $this->in('Password confirmation:'); 
		if ($pwd1 !== $pwd2) { 
			$this->out('Password and confirmation do not match!'); 
			$pwd2 = NULL; 
		}
	}
	
	$user = $this->User->find('first', array(
		'conditions' => array(
			'User.username' => $username
		), 
		'recursive' => -1
	));
	$user['User']['password'] = $this->Auth->password($pwd1);
	if($this->User->save($user)) {
		$this->out('Updated User successfully.');
	} else {
		$this->out('ERROR while updating User!');
	}
}

public function hashpassword() {
	App::import('Component', 'Auth');
	$this->Auth = new AuthComponent;
	$this->out($this->Auth->password($this->args[0]));
}
 
} 
?> 