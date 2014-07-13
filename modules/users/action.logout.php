<?php
    $user = Zend::registry("User");
    $user = new Socnet_User();
    $user->logout();
    $this->_redirect('/');
?>