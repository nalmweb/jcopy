<?php
  $this->_page->Template->assign('crumbs',$this->crumbs);
  $this->_page->Template->assign('message',"Вы можете добавить максимум ".
	     								  BOARD_MAX_ADS." объявления. Чтобы добавить еще, вам " .
	     								  		"надо удалить существующие <a href='/users/ads/'>Объявления</a>");
 
  $this->_page->Template->assign('bodyContent', 'board/board.info.tpl');
?>
