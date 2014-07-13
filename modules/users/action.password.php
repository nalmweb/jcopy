<?php
/*
 *  Created on 01.04.2008
 *  The action to change the password;
 */
 if (! $this->_page->_user->hasAccess ( $this->currentUser )) {
	$this->_redirect ( '/' );
 }
 //dump($this->_page->_user);
 //echo "id  =".$this->_page->_user->getId();
 if($_SERVER['REQUEST_METHOD']=='POST')
 {
 	// check empty on server
 	$pwd = mysql_real_escape_string($_POST['pwd']);
  	$this->_db->update("user",array('pass' =>md5($pwd) ),"id=".$this->_page->_user->getId());
  	// send email about the password.  	
  	$this->_page->Template->assign("message","Пароль был изменен. Ваш новый пароль:".$pwd);
 }
 $this->_page->Template->assign('bodyContent','users/password.tpl');
?>
