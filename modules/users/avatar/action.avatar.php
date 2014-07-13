<?php
// user authorization is required
if (! $this->_page->_user->hasAccess ( $this->currentUser )) {
	$this->_redirect ( '/' );
}
	$avatarListObj = new Socnet_User_Avatar_List($this->currentUser->getId());
	$avatarsList = $avatarListObj->getList();
//print_r($avatarsList); exit;
	$currentAvatar = $this->currentUser->getAvatar();
	$this->_page->Template->assign('avatarsList', $avatarsList);
	$this->_page->Template->assign('user', $this->currentUser);
	$this->_page->Template->assign('currentAvatar', $currentAvatar);
	$this->_page->Template->assign('avatarsLeft', 12-$avatarListObj->getCount());
	$this->_page->Template->assign('bodyContent', 'users/avatar/avatars_list.tpl');
