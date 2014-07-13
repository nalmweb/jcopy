<?php
$objResponse = new xajaxResponse ( ) ;

if (Socnet_User::isUserExists ( 'id', floor ( $friendId ) )) {
	$objResponse->addAssign ( "ajaxMessagePanelTitle", "innerHTML", "Delete Friend" ) ;
	$this->_page->Template->assign ( 'friendId', $friendId ) ;
	$Content = $this->_page->Template->getContents ( 'users/friends_delete.tpl' ) ;
	$objResponse->addAssign ( "ajaxMessagePanelContent", "innerHTML", $Content ) ;
	$objResponse->addScript ( 'MainApplication.showAjaxMessage();' ) ;
} else {
    $this->_redirect ( $BASE_HTTP_HOST ) ;
}
?>