<?php
/*
 * Created on 18.06.2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 ini_set('max_execution_time',0);
 $count = 0;
 
 $this->_db->query("SET NAMES koi8r");
	
 $user=new Socnet_User("id",$_SESSION['user_id']);
 $user->setLogin($email);
 // echo "user = ".$user->getLogin();
 // dump($user);
 // 'USER_INVITE'
 $mail = new Socnet_Mail_Template('id',$tpl_key);
 $mail->setEmailCharset('KOI8-R');
         	    
   $sender_object=new Socnet_User();
   $sender_object->setLogin($email);
   $mail->setSender($sender_object);
   $mail->addRecipient( $user );
   $mail->sendToEmail(true);
   $mail->sendEmailHTMLPart(true);
   $mail->sendEmailTextPart(true);
   $mail->send();
   
 
   ini_set('max_execution_time',30);
   $this->_db->query("SET NAMES utf8");
   
   $objResponse = new xajaxResponse();
   $objResponse->addAlert("Почта отправлена".$tpl_key." == ".$email);
//  }
 /*$this->_page->Template->assign('count',$count);
 $this->_page->Template->assign('bodyContent','admin/mail/mailstatus.tpl');*/
   
  return $objResponse;
?>
