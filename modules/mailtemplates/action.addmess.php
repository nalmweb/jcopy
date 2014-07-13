<?php
/*if (!Socnet_User::hasAccess($this->_page->_user->id, null, 'mailtemplates', 'message','add')){
    $this->_redirectError('ACCESS DENIED');
}*/
    $this->_page->Template->assign('bodyContent', 'mailtemplates/add_message.tpl');
