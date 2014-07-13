<?

$users = new Socnet_User_Collection();

$paginator = new Socnet_Paginator_Item('http://' . BASE_HTTP_HOST . '/cp/users/', $users->getUsersCount());
$pgr = $paginator->getInfo();
$this->_page->Template->assign('pgr', $pgr);

$this->_page->Template->assign('users_array', $users->getUsersList($pgr['current']));


$this->_page->Template->assign('bodyContent', 'cp/users/index.tpl');
$this->_page->Template->assign('menuTab','users');
$this->_page->Template->assign('menuPodTab','users');