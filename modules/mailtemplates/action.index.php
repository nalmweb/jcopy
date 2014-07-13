<?php
  		if (!$this->_page->_user->isAdmin()){
        	$this->_redirectError('ACCESS DENIED');
  		}

$this->_page->Template->assign('bodyContent', 'mailtemplates/view_info.tpl');
