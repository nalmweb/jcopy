<?php
/*
 * Created on 03.06.2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
	if (!$this->_page->_user->isAuthenticated()) {
        $this->_redirect('http://'.BASE_HTTP_HOST.'/admin/');
    }

            
    // show             
 
    $this->_page->Template->assign('bodyContent', 'admin/mail/index.tpl');
 
 
?>
