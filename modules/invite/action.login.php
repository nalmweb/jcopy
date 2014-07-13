<?php

global $login;

if ( Socnet_Http_Cookie::getCookieNamed ( 'SOCNET_LOGIN' ) && 
     Socnet_Http_Cookie::getCookieNamed ( 'SOCNET_PASS' ) &&
     ( bool ) Socnet_Http_Cookie::getCookieNamed ( 'SOCNET_REMEMBER' ) === true 
    ){
    if (Socnet_User::authenticate ( Socnet_Http_Cookie::getCookieNamed ( 'SOCNET_LOGIN' ),Socnet_Http_Cookie::getCookieNamed ( 'SOCNET_PASS' )  )) {
      Socnet_Session::rememberMe ();
      $user = new Socnet_User( 'login', Socnet_Http_Cookie::getCookieNamed ( 'SOCNET_LOGIN' ) );
	    $_SESSION ['user_id'] = $user->getId();
	}
}
else{
  Socnet_Session::regenerateId ();
}

if (!$this->_page->_user->getId()){
	 $form_data = $_POST;
	 $sql = $this->_db->select()->from("user")->where("login =?",$form_data['login']);
	 $rs = $this->_db->fetchAll($sql);
	 if(!empty($rs)){
		  if($rs[0]['status']=='pending'){
		  	$login="login";
		  	$this->_page->Template->assign('invite',true);
		  	$this->_redirect("/");
		  }else{
		  	$login="logged";
		  }
	 }

	 if (Socnet_User::authenticate($form_data['login'], md5($form_data['password']))){
    $login = 'logged';
		$user = new Socnet_User( 'login', $form_data['login'] );
		Zend_Registry::set ( "User", $user );

    $this->_page->_user = & $user;
    $_SESSION['user_id'] = $user->getId();
	 }else{
	  $user = new Socnet_User ( 'id', null );
	 }
}else{
  //$user = new Socnet_User ( 'id', $_SESSION ['user_id'] );
	$sql = $this->_db->select()->from("user")->where("login =?",$form_data['login']);
	$rs = $this->_db->fetchAll($sql);
	if(!empty($rs))
    if($rs[0]['status']=='pending')
    	$login="login";
    else
    	$login = 'logged';
  else
    $login = 'logged';
}

$this->_redirect("/");

?>
