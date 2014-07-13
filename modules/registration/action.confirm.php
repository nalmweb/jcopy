<?php
$form = new Socnet_QuickForm_Page ( 'confirmregistrationForm', 'post', '/registration/confirm/',true ) ;
$form->addElement('text','login', 'Email:');
$form->addElement('password','pass', 'Пароль:');
$form->addRule('login','Введите, пожалуйста, Email.','required');
$form->addRule('login','Введите, пожалуйста, корректный Email.','email');
$form->addRule('nikname','Введите, пожалуйста, ник.','required');
$form->addRule('pass','Введите, пожалуйста, пароль.','required');
$form->addFormRule('checkUserData');

$data = array();

if ($form->validate ( $this->params )) {
	$user = new Socnet_User ( 'login', $this->params [ 'login' ] ) ;

	if ($user->status != 'pending') {
		$form->addRule ( 'login', 'Извините, но этот аккаунт уже подтвержден','required' ) ;
		$form->validate ( $this->params ) ;
	} else {
		$user->pkColName = 'id' ;
		$user->login = $this->params [ 'login' ] ;
		$user->save () ;
		
		//  Send message
		$this->_db->query("SET NAMES koi8r");
		
		$mail = new Socnet_Mail_Template ( 'template_key', 'USER_REGISTER' ) ;
		$mail->setEmailCharset('KOI8-R');
		$sender_object = new Socnet_User ( ) ;
		$mail->setSender ( $sender_object ) ;
		$mail->addRecipient ( $user ) ;
		$mail->send ();
		
		$this->_db->query("SET NAMES utf8");
		
		$_SESSION [ '_reg_user' ] = array ( 'login' => $this->params [ 'login' ] ) ;
		$this->_redirect ( '/registration/confirmcompleted/' ) ;
	}
} else {
	$data = $this->params ;
	//dump($form,$data);
}

$this->_page->setTitle ( 'Подтверждение' ) ;
$renderer = new Socnet_QuickForm_Renderer_ArraySmarty($page->Template);
$form->accept($renderer);

$this->_page->Template->assign('formContent', $renderer->toArray());
$this->_page->Template->assign ( array ( 'form' => $form , 
										 'data' => $data , 
										 'bodyContent' => 'registration/confirm.tpl' ) ) ;

function checkUserData ( $data ) {
	if (! $data [ 'login' ] || ! $data [ 'pass' ]) {
		return false ;
	}
		
	$db = Zend::registry ( "DB" ) ;
	$select = $db->select () ;
	$select->from ( "user", "status" )
		   ->where ( "login = ?", $data [ 'login' ] )
		   ->where ( "pass = ?", md5 ( $data [ 'pass' ] ) ) ;
	
	$res = $db->fetchOne ( $select ) ;
	
	if (!$res)	{
		return array('login' => "Неизвестный пользователь {$data [ 'login' ]}.");
	} elseif ($res != 'pending'){
		return array('login' => "Извините, но этот аккаунт уже подтвержден");
	}
}

function isActive( $data ){
	if (! $data [ 'login' ] || ! $data [ 'pass' ]) {
		return false ;
	}
		
	$db = Zend::registry ( "DB" ) ;
	$select = $db->select () ;
	$select->from ( "user", "id" )
		   ->where ( "login = ?", $data [ 'login' ] )
		   ->where ( "pass = ?", md5 ( $data [ 'pass' ] ) ) ;
	
	$res = $db->fetchOne ( $select ) ;
	
	if (!$res)	return array('login' => "Неизвестный пользователь {$data [ 'login' ]}.");
}
?>