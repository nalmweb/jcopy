<?php
/*
 * Created on 01.08.2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 $user_id = isset($_SESSION['user_id'])?$_SESSION['user_id']:0;
 
 $objResponse = new xajaxResponse();  
 
 /*$objResponse->addAlert("owner 111");
 return $objResponse;*/
	   
 if(empty($user_id)){
   	$objResponse->addAlert("Вам нужно войти, чтобы выполнить это действие.");	
	return $objResponse;
 }
  
 $item = new Socnet_Board_Item($cat_id, $item_id); 
 
  if(!$item->isOwner()  )
  {
  	 $objResponse->addAlert("Вы не можете выполнить это действие, т.к. вы не владелец.");	
	 return $objResponse;
  }
  
  // $objResponse->addAlert("owner");
  
  if(!$item->canAdd() && $status !=1)
  {
  	 $objResponse->addAlert("Вы не можете выполнить это действие, т.к. у вас превышено допустимое число объявлений.");	
	 return $objResponse;
  }
  // set is_active =1, update dates for a months.
  
  $color = '';
  $tpl   = '';
  
  if($status)
  {
	$status = 0;
	$color  = "table_row.style.color='#a9a9a9'; ";
	$tpl    = "activate";
  }
  else
  {
  	$status =1;
  	$color  ="table_row.style.color='#000000'; ";
  	$tpl    ="deactivate";
  }
  $values = array('is_active' => $status,'reg_date'=>'NOW()','end_date'=> 'NOW() + '.MONTH );
  $this->_db->update($item->getTableName(),$values,"id = $item_id");
  // update status for the row!
  $elem_id = $cat_id.'_'.$item_id;
  $objResponse->addScript(" var table_row=document.getElementById('$elem_id'); " );
  //$objResponse->addScript( 'alert(table_row.id);' );
  $objResponse->addScript( $color );
  //
  $this->_page->Template->assign('catId' ,$cat_id);
  $this->_page->Template->assign('itemId',$item_id);
  
  $html = $this->_page->Template->getContents("users/private/buttons/$tpl.tpl");
  $objResponse->addAssign('btn_'.$elem_id,'innerHTML',$html );
  // set color
   
  return $objResponse;