<?php
/**
 *   Created on 31.07.2008
 *      Makes an ad active again.  
 *   // check session 
 *   // check owner
 *   // check can add!  
 */
 
 $objResponse = new xajaxResponse(); 
 
 $objResponse->addAlert("owner");
 
 return $objResponse; 
 
 $user_id = isset($_SESSION['user_id'])?$_SESSION['user_id']:0;
	   
 if(empty($user_id)){
   	$objResponse->addAlert("Вам нужно войти, чтобы выполнить это действие.");	
	return $objResponse;
 }
  
 $item = new Socnet_Board_Item($cat_id, $item_id); 
 
  if(!$item->isOwner())
  {
  	 $objResponse->addAlert("Вы не можете выполнить это действие, т.к. вы не владелец.");	
	 return $objResponse;
  }
  
  $objResponse->addAlert("owner");
  
  if(!$item->canAdd())
  {
  	 $objResponse->addAlert("Вы не можете выполнить это действие, т.к. у вас превышено допустимое число объявлений.");	
	 return $objResponse;
  }
  // $objResponse->addAlert("update");
  // set is_active =1, update dates for a months.
  $status = ($status==1)?0:1;
  $values = array('is_active' => 1,'reg_date'=>'NOW()','end_date'=> 'NOW() + '.MONTH );
  $this->_db->update($item->getTableName(),$values,"id = $item_id");
  
  // update status for the row!
   $objResponse->addScript(" var id=document.getElementById($cat_id+'_'+$item_id); " );
   $objResponse->addScript("     alert(id.id) " );
   
   if($status)
       $objResponse->addScript("     id.style.color='#000000'; " );
   else    
   	   $objResponse->addScript("     id.style.color='#a9a9a9'; " );
   
  return $objResponse;
