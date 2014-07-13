<?php
/*
 * Created on 18.06.2008
 * 
 */
 // --> send email::
  $count =0; 
  $this->_db->query("SET NAMES koi8r");	
  $email = "konan.com@gmail.com";
  $user=new Socnet_User("id",$_SESSION['user_id']);
  $user->setLogin($email);
   // echo "user = ".$user->getLogin();
   // dump($user); 
   // 'USER_INVITE'
   $TEMPLATE_KEY='USER_INVITE';
   
   $mail = new Socnet_Mail_Template('id',27);
   $mail->setEmailCharset('KOI8-R');
   $sender_object=new Socnet_User();
   $sender_object->setLogin($email);
   $mail->setSender($sender_object);
   $mail->addRecipient( $user );
   $mail->sendToEmail(true);
   $mail->sendEmailHTMLPart(true);
   //$mail->sendEmailTextPart(true);
   $mail->send();
   $count ++;
   ini_set('max_execution_time',30);
   $this->_db->query("SET NAMES utf8");
// <--
?>
