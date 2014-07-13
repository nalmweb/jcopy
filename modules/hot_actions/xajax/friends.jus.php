<?
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
		
		$objResponse->addScript ('MainApplication.showAjaxMessage();');
	} else {
		$this->_redirect ($BASE_HTTP_HOST);
	}
}

$objResponse = new xajaxResponse();
if (null !== $userId) {
    if (Socnet_User::isUserExists('id', floor($userId))) {
        if ($this->_page->_user->getId() !== $userId) {
            $oUser = new Socnet_User('id', $userId);
            $sendRequest = false;
            if (false === $sendAgain) {
                $oFriendsRequests = new Socnet_User_Friend_Request_List();
                if ($oFriendsRequests->setSenderId($this->_page->_user->getId())->setRecipientId($userId)->getCount()) {
                    $this->_page->Template->assign('alredySent', 1);
                    $sendRequest = false;
                } else {
                    $sendRequest = true;
                }
            } else {
                $sendRequest = true;
            }
            if ($sendRequest) {
                $oFriends = new Socnet_User_Friend_Request_Item();
                $oFriends->setSenderId($this->_page->_user->getId());
                $oFriends->setRecipientId($userId);
                $oFriends->setRequestDate(time());
                if ($oFriends->save()) {
                    //  Send message
                    $mail = new Socnet_Mail_Template('template_key', 'USERS_FRIEND_INVITE');
                    $mail->setSender($this->_page->_user);
                    $mail->addRecipient(new Socnet_User('id', $userId));
                    $mail->sendToPMB(true);
                    $mail->sendToEmail(true);
                    $mail->addParam('message', $message);
                    $mail->send();
                    $oFriends->addRelation($mail->message);
                    $infoMessage = "An invitation sent";
                    $objResponse->addScript("MainApplication.hideAjaxMessage();");
                    $objResponse->showAjaxAlert($infoMessage);
                }
            } else {
                $objResponse->addAssign("ajaxMessagePanelTitle", "innerHTML", "Add to friends");
                $this->_page->Template->assign('friend', $oUser);
                $Content = $this->_page->Template->getContents('users/addfriend.popup.tpl');
                $objResponse->addAssign("ajaxMessagePanelContent", "innerHTML", $Content);
                $objResponse->addScript('MainApplication.showAjaxMessage();');
            }
        } else {
            $objResponse->addRedirect(BASE_HTTP_HOST);
        }
    }
    else {
        $objResponse->addRedirect(BASE_HTTP_HOST);
    }
}
?>