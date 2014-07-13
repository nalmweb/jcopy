<?php
   // on unscubscribe -> delete row from subscribers.
   $user_id = $_SESSION['user_id'];
   $objResponse = new xajaxResponse();
   
   if(empty($user_id))
   {
     	$objResponse->addAlert('Чтобы отписаться вам надо войти.');
     	return $objResponse;
   }
   //$meeting_id = mysql_real_escape_string()
   $meeting = new Socnet_Meeting($meeting_id);
   if($meeting->removeSubscriber($user_id))
   {
       $objResponse->addScript(" var elem = document.getElementById('m_$meeting_id')");
       $objResponse->addScript(" elem.parentNode.removeChild(elem)");
   }
   else
   {
      $objResponse->addAlert("Вы уже отписались.");
   }
   
   
   