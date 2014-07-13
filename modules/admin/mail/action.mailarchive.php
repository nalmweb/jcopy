<?php
/*
 * Created on 30.05.2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 //
 
 $archive = new Socnet_Mail_Broadcast();
 
 $list=$archive -> getList();
 $this->_page->Template->assign('list',$list);
 $this->_page->Template->assign('bodyContent', 'admin/mail/mail.archive.tpl'); 
?>
