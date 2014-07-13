<?php 
  if (!$this->_page->_user->isAuthenticated()) {
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  }
  elseif (!$this->_page->_user->isAdmin()){
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  }
  
  // показать список рассылок ( название, дата, отправлено: всем, неотправлено: кол-во. )
 
  // echo "$pass <br >";
  // status = pending | active
  /*$sql=$this->_db->select()->from(array( 't1' => "user"),
  								  array("id", "login", "nikname", "status", "register_code"))
  								  ->where(" 1 ")
  								  ->joinLeft(array ("t2"=>'user__mail'),"t1.id=t2.user_id")
  								  ->order("is_sent ASC");
  $rs = $this->_db->fetchAll($sql);
  // dump($rs);
  //exit;
  $this->_page->Template->assign('users',$rs);*/
  $this->_page->Template->assign('bodyContent', 'admin/mail/index.tpl'); 
?>
