<?php
/*
 * Created on 17.01.2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
  
  $values = $_POST;
  
  $message=$values['message'];
  $subject=$values['subject'];
  $contacts=$values['contacts'];
  /*
string to, string subject, string message [, string additional_headers [, string additional_parameters]])

      mail("nobody@example.com", "the subject", $message,
     "From: webmaster@{$_SERVER['SERVER_NAME']}\r\n" .
     "Reply-To: webmaster@{$_SERVER['SERVER_NAME']}\r\n" .
     "X-Mailer: PHP/" . phpversion());
   */
  $res = mail("freezip@gmail.com","Обратная связь:".$subject,$message,"From: ".$contacts);
  
  
  if($res)
  {
    $this->_page->Template->assign('message',"Ваше сообщение отправлено! Спасибо за участие!");
    $this->_page->Template->assign('bodyContent', 'feedback/feedback.status.tpl');    	
  }
  else
  {
  	$this->_page->Template->assign('message',"По техническим причинам Ваше сообщение не было отправлено! Тем не менее, спасибо за участие!");
  	$this->_page->Template->assign('bodyContent', 'feedback/feedback.status.tpl');
  }
  // email - send it somewhere now!
  // dump($values);
?>
