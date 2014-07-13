<?
  // Show window, using template
  $objResponse = new xajaxResponse();
  // get window
  $content = $this->_page->Template->getContents('hot_actions/sendMessage.popup.tpl');
  // $this->_page->Template->assign('msg',$content);
  $objResponse->addAssign('msg',$content);
  $objResponse->addScript("showDialog('msg')");
?>