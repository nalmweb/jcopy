<?
if (!$this->_page->_user->isAuthenticated()) {
  $this->_redirect('http://'.BASE_HTTP_HOST.'/cp/');
}

//$form = new Socnet_Form('search_user', 'POST', 'http://'.BASE_HTTP_HOST."/".$this->_page->Locale.'/users/search/');
$this->_page->setTitle('Админка');
$this->_page->Template->assign(array(
  'bodyContent'   => 'cp/cp.tpl',
));