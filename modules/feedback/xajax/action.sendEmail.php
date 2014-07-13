<?php
/*
 * Created on 17.01.2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
  $objResponse = new xajaxResponse();
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
  mail("freezip@gmail.com","Обратная связь:".$subject,$message,"From: ".$contacts);
  // email - send it somewhere now!
  // dump($values);
  $objResponse->addAlert("Спасибо! Ваше сообщение отправлено!");
  return $objResponse;  
?>
