<?php
/*
 * Created on 12.02.2008
 
 */
	$objResponse = new xajaxResponse();
	$sql=$this->_db->select()->from("user")->where('nikname=?',$nick); 
	$rs = $this->_db->fetchOne($sql);
	// ============================
	// Set OK - not exists
	if(empty($rs))
	{
	  // set OK image
	  $objResponse->addAssign("status","innerHTML", '<img src="/images/ok.png">');
	  $objResponse->addScript('document.forms[0].submit.disabled=false;');
	//  $objResponse->addAssign("submit","disabled", 'enabled');
	}
	// can't login - exists
	else
	{
	  $objResponse->addAssign("status","innerHTML", '<img src="/images/cancel.png">');
	  $objResponse->addScript('document.forms[0].submit.disabled=true;');
	  //$objResponse->addAssign("submit","disabled", 'disabled');    	
	}
	return $objResponse;
/*
  	как сделать enabled / disabled?
  	 
*/
?>

