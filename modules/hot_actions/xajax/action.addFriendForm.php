<?
  $objResponse = new xajaxResponse ();
  
if (null !== $user_id)
{
	 //if (Socnet_User::isUserExists ( 'id', floor ( $user_id ) ))
	 if (Socnet_User::isUserExists ( 'id', $user_id ))
	 {
		// $objResponse->addAssign("ajaxMessagePanelTitle", "innerHTML", "Add to friends");
		$oFriendsRequests = new Socnet_User_Friend_Request_List ( ) ;
		if ($oFriendsRequests->setSenderId ( $this->_page->_user->getId () )->setRecipientId ( $user_id )->getCount ())
		{
			$objResponse->addAlert("Вы уже отправили приглашение данному пользователю.");
			$this->_page->Template->assign ( 'alredySent', 1 ) ;
			return $objResponse;
		}
		if (Socnet_User_Friend_Item::isUserFriend ( $this->_page->_user->getId (), $user_id ))
		{
			$oFriend = new Socnet_User ( 'id', $user_id ) ;
			// $infoMessage [] = "{$oFriend->getLogin()} уже ваш друг." ;
			$objResponse->addAlert("Данный пользоватрель уже Ваш друг.");
			return $objResponse; 
			$this->_page->Template->assign ( 'errors', $infoMessage );
			
		}
		elseif ($_SESSION['user_id'] == $user_id)
		{
			$infoMessage [] = "Самого себя в друзья добавить нельзя!" ;
			$objResponse->addAlert("Самого себя в друзья добавить нельзя!");
			return $objResponse;
			// $this->_page->Template->assign ( 'errors', $infoMessage ) ;
		} else {
			$this->_page->Template->assign ('friend', new Socnet_User ('id',$user_id));
		}
		//$objResponse->addAlert("passed");
		//return $objResponse;		
		//$this->_page->Template->assign ( 'empty', rand ());
		$this->_page->Template->assign('friend_id',$user_id);
		$Content = $this->_page->Template->getContents ( 'users/addfriend.popup.tpl' );
		$objResponse->addAssign( "ajaxContent", "innerHTML", $Content );
		$objResponse->addScript("openMyDialog('ajaxContent')");
		//$objResponse->addAlert($Content);
		//$objResponse->addScript( 'MainApplication.showAjaxMessage();' ) ;
	}
	else
	{
		//$objResponse->addAlert("!exists");
		//return $objResponse;
		$this->_redirect ($BASE_HTTP_HOST ) ;
	}
}
?>
