<?php
if (!$this->_page->_user->isAdmin()){
   	$this->_redirectError('ACCESS DENIED');
}

    $mailtpl_Obj = new Socnet_Mail_Templates();
	$templatesList = $mailtpl_Obj->getAllTemplatesList();

    $this->_page->Template->assign('templatesList', $templatesList);
    $this->_page->Template->assign('bodyContent', 'mailtemplates/view_records.tpl');