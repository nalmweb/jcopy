<?	
if (!isset($_SESSION['reg_user'])){
    $this->_redirect('/');
}
$this->_page->setTitle('Регистрация');

$this->_page->Template->assign(array(
    'userData'          => $_SESSION['reg_user'],
    'fromRegistration'  => true,
    'bodyContent'       => 'registration/completed.tpl'));

unset($_SESSION['reg_user']);


