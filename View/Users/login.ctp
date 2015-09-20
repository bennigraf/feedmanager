<div class="form">
<?php
    echo $this->Session->flash('auth');
    echo $this->Form->create('User');
    echo $this->Form->input('username', array('type' => 'text'));
    echo $this->Form->input('password');
    echo $this->Form->end('Login');
?> </div>