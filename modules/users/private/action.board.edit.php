<?php
/*
 * Created on 10.06.2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 if(!isValidSession())
 {
 	$this->redirect("/"); // todo: redir 2 login
 }
 
 $cat_id = getUrlParam("cat");
 $item_id = getUrlParam("item");
 
 if(empty($cat_id))
 {
   $this->_redirect("/users/ads/");   
 }
 if(empty($item_id)){
   $this->_redirect("/users/ads/");
 } 
 
 // check acccess:
 $ad = new Socnet_Board_Item($cat_id,$item_id);
 
 if(!$ad->isOwner())
 {
 	$this->_redirect('/users/cantmodify/');
 }
 
 // Show 
 switch($cat_id)
 {
 	case BIKES: include_once('./modules/users/private/action.board.edit.bike.php');    break;
 	
 	default:
 		$this->_redirect("/users/ads/");
 	   break;
 }
?>
