<?php
if (!$this->_page->_user->isAdmin()){
   	$this->_redirectError('ACCESS DENIED');
}  
    $this->_page->Template->assign('bodyContent', 'mailtemplates/add_record.tpl');
