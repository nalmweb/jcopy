<?php
$objResponse = new xajaxResponse ( ) ;

if ($requestId == 'all') {
	$oFriendsRequests = new Socnet_User_Friend_Request_List ( ) ;
	$oFriendsRequests->setRecipientId( $this->_page->_user->getId () )->setIsSender ( false )->returnAsAssoc ( false ) ;
	$rFriends = $oFriendsRequests->getList () ;
} else {
	$rFriends [] = new Socnet_User_Friend_Request_Item ( intval ( $requestId ) ) ;
}

if ($rFriends) {
	foreach ( $rFriends as $oFriendRequest ) {
		//@todo Добавить отправку мыла о том, что запрос приенят !??
		$oFriend = new Socnet_User_Friend_Item ($oFriendRequest->getSenderId (), $oFriendRequest->getRecipientId () ) ;
		$oFriend->setUserId ( $oFriendRequest->getSenderId () ) ;
		$oFriend->setFriendId ( $oFriendRequest->getRecipientId () ) ;
		
		if ( !$oFriend->isUserFriend() ) {
		  $oFriend->setCreatedDate ( time() ) ;
		  $oFriend->save () ;
		}
		
		if ( $requestId == 'all' ) {
		  $oFriendRequest->delete () ;
		} else {
		  $oFriendRequest->deleteAll () ;
		}
	}
	$objResponse->addAlert('Приглашение принято');
    }

$objResponse->addRedirect ( $this->_page->_user->getUserPath('friends/requests/received') ) ;
?>