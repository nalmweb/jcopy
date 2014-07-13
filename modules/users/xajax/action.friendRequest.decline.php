<?php
$objResponse = new xajaxResponse ( ) ;

if ($requestId == 'all') {
	$oFriendsRequests = new Socnet_User_Friend_Request_List ( ) ;
	$oFriendsRequests->returnAsAssoc ( false ) ;
	
	if (! $redirect) {
		$oFriendsRequests->setIsSender ( false )->setRecipientId( $this->_page->_user->getId () ) ;
	}elseif ($redirect == 'sent') {
		$oFriendsRequests->setIsSender ( true )->setSenderId( $this->_page->_user->getId () ) ;
	}
	
	$rFriends = $oFriendsRequests->getList () ;
} else {
	$rFriends [] = new Socnet_User_Friend_Request_Item ( intval ( $requestId ) ) ;
}

if ($rFriends) {
	foreach ( $rFriends as $oFriendRequest ) {
		//@todo Добавить отправку мыла о том, что запрос отклонен
		if ($redirect && $redirect == 'sent') {
		  $oFriendRequest->delete () ;
		  
		  $this->_page->showAjaxAlert('Deleted');
		} else {
			$oFriendRequest->deleteAll () ;
			$this->_page->showAjaxAlert('Declined');
		}
	}
        if ($redirect && $redirect == 'sent') {
          $this->_page->showAjaxAlert('Deleted');
        } else {
          $this->_page->showAjaxAlert('Declined');
        }
}



$_SESSION['AjaxAlertProperty'] = $this->_page->getAjaxAlertProperty();

if (null == $redirect) {
	$objResponse->addRedirect ( $this->_page->_user->getUserPath ( '/friends/requests/received' ) ) ;
} elseif ($redirect == 'sent') {
	$objResponse->addRedirect ( $this->_page->_user->getUserPath ( '/friends/requests/sent' ) ) ;
}
?>