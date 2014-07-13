<?php

require_once 'core/Socnet.php';
Socnet::parseURI();

$page->Template->assign('MOD_NAME', Socnet::$controllerName);
$page->Template->assign('ACTION_NAME', Socnet::$actionName);

ini_set('display_errors', 0);

$page->Template->setTemplatesDir(DOC_ROOT.'/admin/templates');
$page->Template->setCompiledDir(DOC_ROOT.'/var/_compiled/admin/');

$user = new Socnet_User("id", $_SESSION['user_id']);
Zend::register("User", $user);
$page->setTitle('АДМИНИСТРАТИВНАЯ ПАНЕЛЬ');

$_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'], strlen('/tms'));

try {
    Zend_Controller_Front::run(ADMIN_DIR.'modules/'.Socnet::$controllerName);
    $user_id = $_SESSION['user_id'];

} catch (Exception $error) {
    $page->Template->assign('ERROR_MESSAGE', $error);
    $page->Template->assign('bodyContent', 'error.html');
}

$page->Template->render($page->Template->layout);
$this->_page->Template->assign('menuPodTab','index');
