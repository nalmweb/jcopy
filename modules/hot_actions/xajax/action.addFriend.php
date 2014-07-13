<?php
$objResponse = new xajaxResponse ();

if (null !== $userId) {
	if (Socnet_User::isUserExists ( 'id', floor ( $userId ) )) {

		$objResponse->addAssign ( "ajaxMessagePanelTitle", "innerHTML", "Add to friends" ) ;
		
		$oFriendsRequests = new Socnet_User_Friend_Request_List ( ) ;

		if ($oFriendsRequests->setSenderId ( $this->_page->_user->getId () )->setRecipientId ( $userId )->getCount ())
		{
			$this->_page->Template->assign ( 'alredySent', 1 ) ;
		}
		
		if (Socnet_User_Friend_Item::isUserFriend ( $this->_page->_user->getId (), $userId )) {
			$oFriend = new Socnet_User ( 'id', $userId ) ;
			$infoMessage [] = "{$oFriend->getLogin()} is already your friend." ;
			$this->_page->Template->assign ( 'errors', $infoMessage ) ;
		} elseif ($this->_page->_user->getId () == $userId) {
			$infoMessage [] = "Yoy can not add to friends yourself." ;
			$this->_page->Template->assign ( 'errors', $infoMessage ) ;
		} else {
			$this->_page->Template->assign ( 'friend', new Socnet_User ( 'id', $userId ) ) ;
		}
		
		$this->_page->Template->assign ( 'empty', rand () ) ;
		$Content = $this->_page->Template->getContents ( 'users/addfriend.popup.tpl' ) ;
		$objResponse->addAssign ( "ajaxMessagePanelContent", "innerHTML", $Content ) ;
		
		$objResponse->addScript ( 'MainApplication.showAjaxMessage();' ) ;
	} else {
		$this->_redirect ( $BASE_HTTP_HOST ) ;
	}
}
?>