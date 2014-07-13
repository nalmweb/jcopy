<?php

if(!Socnet_Access::hasAccess($this->_page->_user->id, null, 'mailtemplates','settings','edit')){
    $this->_redirectError('ACCESS DENIED');
}

$form = new Socnet_QuickForm_Page('accessForm', 'post',(USE_USER_PATH ? $this->use_user_path : '/').$this->_page->Locale.'/settings/');
$form->addElement($f1 = new Socnet_QuickForm_errorsummary());
$form->addElement($f2 = new HTML_QuickForm_text('username', 'Input username:', array('style' => 'width:180px;')));
$form->addElement($f6 = new Socnet_QuickForm_submit('submit', 'ADD USER', 'orange'));
$form->applyFilter('username', 'trim');
$form->addRule('username','Enter please username','required');

if ($form->validate()) {

    if (Socnet_User::isUserExists('login',$f2->getValue())){
        
        $userInfo = new Socnet_User('login',$f2->getValue());
        
        Socnet_Access::addRole($userInfo->id, 'Mail Templates Admin');
        
        
        $this->_redirect('/'.$this->_page->Locale.'/adduserok/');
    }
    else {
        $this->_redirect('/'.$this->_page->Locale.'/adduser/');
    }
}


$renderer = new Socnet_QuickForm_Renderer_Default();
$form->accept($renderer);

$this->_page->Template->assign('formContent', $renderer->toHtml());

//
$accessList = Socnet_Access::getUsersListByRole('Mail Templates Admin');

$this->_page->Template->assign('accessList', $accessList);

$this->_page->Template->assign('bodyContent', 'mailtemplates/settings.tpl');
