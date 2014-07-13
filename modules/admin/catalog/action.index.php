<?php
  if (!$this->_page->_user->isAuthenticated()) {
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  } elseif (!$this->_page->_user->isAdmin()){
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  }
$this->_page->Template->assign('bodyContent', 'admin/catalog/index.tpl');
$this->_page->Template->assign('menuTab','catalog');
$this->_page->Template->assign('menuPodTab','catalog');
?>