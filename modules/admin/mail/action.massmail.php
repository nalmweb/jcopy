<?php
/*
 * Created on 30.05.2008
    1) choose template.
    2) send
*/ 
 $templatesList = new Socnet_Mail_List();
 $templatesList = $templatesList->getList();
 
 $this->_page->Template->assign('list', $templatesList);
 $this->_page->Template->assign('bodyContent', 'admin/mail/mail.massmail.tpl');
?>
