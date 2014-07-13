<?php
/*
 * Created on 05.12.2007
 *
	3 types of search: bikes, details, outfit;;

 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 $cat_id =  intval(Socnet::$urlParams[3]);
 

 if($cat_id==1)
     		$this->_page->Template->assign('bodyContent', 'board/board.item_bike.tpl');
     else if($cat_id==2)		
     		$this->_page->Template->assign('bodyContent', 'board/board.item_details.tpl');
     else if($cat_id==3)
     		$this->_page->Template->assign('bodyContent', 'board/board.item_outfit.tpl'); 
  
 
 
?>
