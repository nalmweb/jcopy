<?php
if ($this->_page->_user->isAuthenticated()) {
    $this->_redirect($this->currentUser->getUserPath('profile'));
}

$data = array();
$user = false;
$form_nikname = new Socnet_QuickForm_Page('restoreViaNikname', 'POST','/users/restore/',true);

$form_nikname->addElement('text', 'nikname', 'Ник: ');
$form_nikname->addRule('nikname', 'Введите Ваш ник', 'required');
$form_nikname->addFormRule('validateUser');

$form_login = new Socnet_QuickForm_Page('restoreViaLogin', 'POST','/users/restore/', true);
$form_login->addElement('text', 'login', 'Логин: ');
$form_login->addRule('login', 'Введите Ваш логин', 'required');
$form_login->addRule('login', 'Логин не корректный', 'email');
$form_login->addFormRule('validateUser');

if (isset($this->params['nikname']) && $form_nikname->validate($this->params)) {
    $user = new Socnet_User('nikname', $this->params['nikname']);
} elseif (isset($this->params['login']) && $form_login->validate($this->params)) {
    $user = new Socnet_User('login', $this->params['login']);
} else {
    $data = $this->params;
}
$_template = 'users/restore.tpl';

if ($user && $user->id) {
    $user->restorePassword();
    $_template = 'users/restore.confirm.tpl';
}

    $rendererNikname = new Socnet_QuickForm_Renderer_ArraySmarty($page->Template);
    $rendererLogin = new Socnet_QuickForm_Renderer_ArraySmarty($page->Template);
    $form_nikname->accept($rendererNikname);
    $form_login->accept($rendererLogin);
    
    $this->_page->Template->assign(array('data' => $data , 
									 	 'formLogin' => $rendererLogin->toArray() , 
									 	 'formNikname' => $rendererNikname->toArray() , 
									 	 'bodyContent' => $_template));
    
    function validateUser ($fields) 
    {
        if (isset($fields['login']) && true !== Socnet_User::isUserExists('login',$fields['login'])) {
            return array('login' => 'Пользователь с логином '.$fields['login']. ' не зарегистрирован в системе.');
        }

        if (isset($fields['nikname']) && true !== Socnet_User::isUserExists('nikname',$fields['nikname'])) {
           return array('nikname' => 'Пользователь с ником '.$fields['nikname']. 'не зарегистрирован в системе.');
        }

        return true;
    }