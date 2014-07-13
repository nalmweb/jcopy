<?php

/*if (!Socnet_Access::hasAccess($this->_page->_user->id, null, 'mailtemplates','message','view') ){
    $this->_redirectError('ACCESS DENIED');
}*/

$mailmsg_Obj = new Socnet_Mail_Templates();
$messagesList = $mailmsg_Obj->getAllMessagesList();

$this->_page->Template->assign('messagesList', $messagesList);

$this->_page->Template->assign('bodyContent', 'mailtemplates/view_messages.tpl');

//exit;

?>