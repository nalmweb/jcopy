<?php
    if ( $this->_page->_user->isAuthenticated() ) {
        if ( USE_USER_PATH ) {
            $this->_redirect($this->_page->_user->user_adv_path.'/profile/');
        } else {
            $this->_redirect('http://'.BASE_HTTP_HOST.'/users/profile/');
        }
    }
    //________________________________________________________

    $form = new Socnet_QuickForm_Page('loginForm', 'post', '/');
    $items = array();
    $items['login']     = new HTML_QuickForm_text('login', 'Логин:', array('style' => 'width:100px;'));
    $items['password']  = new HTML_QuickForm_password('password', 'Пароль:', array('style' => 'width:100px;'));
    $items['submit']    = new Socnet_QuickForm_submit('submit', 'ВХОД', 'orange');


    $form->addElements($items);

    $form->addRule('login','Enter please Username','required');
    $form->addRule('password','Enter please Password','required');
    $form->addFormRule('validateLogin');


    //^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    //                                                       //
    //  FORM Hendler
    //                                                       //
    //^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    if ( $form->validate() ) {
        $form_data = $form->exportValues();
        $user = Zend::registry("User");
        $user = new Socnet_User('login', $form_data['login']);
        $user->authenticate();
        $this->_redirect('/users/profile/');
    }
    //^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

    $renderer = new Socnet_QuickForm_Renderer_ArraySmarty($this->_page->Template);
    $renderer = new Socnet_QuickForm_Renderer_ArraySmarty($this->_page->Template);
    $form->accept($renderer);

    $this->_page->setTitle('Log In');
    $this->_page->Template->assign('hideBottomMenu', true);
    $this->_page->Template->assign('loginFormData', $renderer->toArray());
    $this->_page->Template->assign('bodyContent', 'users/login.tpl');

    /**
     * Функция валидации логина и пароля пользователя в базе
     *
     */
  /*  function validateLogin($fields)
    {
        if ( false === Socnet_User::validateLogin($fields['login'], $fields['password']) ) {
            return array('login' => 'Incorrect username or password');
        }
        return true;
    }*/