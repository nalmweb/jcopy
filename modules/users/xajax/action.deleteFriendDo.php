<?php
$objResponse = new xajaxResponse ( ) ;
if (Socnet_User::isUserExists ( 'id', floor ( $friendId ) )) {
	$friend = new Socnet_User_Friend_Item ( $this->_page->_user->getId (), $friendId ) ;
	
	if ($friend->delete ()) {
		$objResponse->addScript ( "MainApplication.hideAjaxMessage();" ) ;
		$this->_page->showAjaxAlert('Deleted');

        $_SESSION['AjaxAlertProperty'] = $this->_page->getAjaxAlertProperty();
		$objResponse->addRedirect ( "/" . LOCALE . "/friends/" ) ;
	}
} else {
	$this->_redirect ( $BASE_HTTP_HOST ) ;
}
?>