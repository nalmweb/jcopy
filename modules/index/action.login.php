<?php
    
    dump($_POST);
	$this->_page->Template->assign('invite', 'false');
	
	$login    = $_POST['login'];
	$password = $_POST['password'];
    
    if ( $this->_page->_user->isAuthenticated() ) {
        if ( USE_USER_PATH ) {
            $this->_redirect($this->_page->_user->user_adv_path.'/profile/');
        } else {
            $this->_redirect('http://'.BASE_HTTP_HOST.'/users/profile/');
        }
    }
    //^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    //                                                       //
    //  FORM Hendler
    //                                                       //
    //^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    $user = Zend::registry("User");
    $user = new Socnet_User('login', $login);
    $user->authenticate();
    $this->_redirect('/users/profile/');
    
    //^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    /**
     *   Функция валидации логина и пароля пользователя в базе
     */
    function validateLogin($fields)
    {
        if ( false === Socnet_User::validateLogin($fields['login'], $fields['password']) ) {
            return array('login' => 'Incorrect username or password');
        }
        return true;
    }