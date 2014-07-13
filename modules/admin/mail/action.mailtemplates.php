<?php
/*
 * Created on 30.05.2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 $this->_page->Xajax->registerUriFunction("sendDemoMail","/admin/sendDemoMail/");
 
 // get a list of mail templates 
 $list = new Socnet_Mail_List();
 $list->returnAsAssoc(false);
 $list = $list->getList();
 
 //dump($list);
 
 $this->_page->Template->assign('list',$list); 
 $this->_page->Template->assign('bodyContent', 'admin/mail/mail.templates.tpl');
 
?>
