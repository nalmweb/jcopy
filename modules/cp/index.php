<?php

require_once 'core/Socnet.php';
Socnet::parseURI();

$page->Template->assign('MOD_NAME', Socnet::$controllerName);
$page->Template->assign('ACTION_NAME', Socnet::$actionName);
