<?php
// user authorization is required
if (! $this->_page->_user->hasAccess ( $this->currentUser )) {
	$this->_redirect ( '/' );
}
	$avatar_id = isset($this->params['avatar']) ? (int)floor($this->params['avatar']) : 0;
	if ($avatar_id === 0) $this->_redirect($this->_page->_user->getUserPath("avatars"));
	$avatarListObj = new Socnet_User_Avatar_List($this->_page->_user->getId());
	$avatarListObj->returnAsAssoc();
	$avatarsList = $avatarListObj->getList();
	
	if (! key_exists($avatar_id, $avatarsList)){
	    $this->_redirectError(Socnet::t("Error. Invalid avatar id."));
	}
	
	$avatar = new Socnet_User_Avatar($avatar_id);
	$avatar->delete();
	
	
	$this->_redirect($this->currentUser->getUserPath("avatars"));
