<?php
/*
 * Created on 01.08.2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 $user_id 	  = isset($_SESSION['user_id'])?$_SESSION['user_id']:0;
 
 $objResponse = new xajaxResponse();  
 
 /*$objResponse->addAlert("owner 111");
 return $objResponse;*/
	   
 if(empty($user_id)){
   	$objResponse->addAlert("Вам нужно войти, чтобы выполнить это действие.");	
	return $objResponse;
 }
  
  // 
 $item = new Socnet_Ugon_Item($item_id); 
 
  if(!$item->isOwner())
  {
  	 $objResponse->addAlert("Вы не можете выполнить это действие, т.к. вы не владелец.");	
	 return $objResponse;
  }
  
  //
  $values = array('is_active' => 0);
  $this->_db->update($item->getTableName(),$values,"id = $item_id");
     
  // hide element
  $objResponse->addScript(" var table_row=document.getElementById('tr_$item_id'); " );
  $objResponse->addScript(" table_row.parentNode.removeChild(table_row);          " );
  
  return $objResponse;
?>
