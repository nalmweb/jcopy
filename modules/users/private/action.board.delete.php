<?php
/*
 	 // check session
 	  * check owner
*/
   if(isValidSession())
   {
   	  //
   	  $cat_id = intval(getUrlParam("cat"));  
   	  $id     = intval(getUrlParam("item"));
   	     	  
   	  if(!empty($cat_id) && !empty($id))
   	  {
   	  	$boardItem = Socnet_Board_Factory::getInstance($cat_id,$id) ;
   	  	
   	  	if($boardItem->isOwner())
   	  		$boardItem->deleteItem();
   	  		
   	  	$this->_redirect("/users/ads/");
   	  }   	  
   	  else 
   	  {
   	  	$this->_redirect("/"); // redirect to some error.
   	  }
   }
   // redirect to: login
   else{
   	
   } 
?>
