<?php
if (! isset ( $_SESSION [ '_reg_user' ] )) {
	$this->_redirect ( '/' ) ;
}

$this->_page->setTitle ( 'Подтверждающее письмо отправлено' ) ;
$this->_page->Template->assign ( array ( 'userData' => $_SESSION [ '_reg_user' ] , 
										 'fromRegistration' => false , 
										 'bodyContent' => 'registration/completed.tpl' ) ) ;

unset ( $_SESSION [ '_reg_user' ] ) ;