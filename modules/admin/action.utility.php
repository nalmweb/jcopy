<?php

if (! $this->_page->_user->isAuthenticated ()) {
	$this->_redirect ( 'http://' . BASE_HTTP_HOST . '/' );
} elseif (! $this->_page->_user->isAdmin ()) {
	$this->_redirect ( 'http://' . BASE_HTTP_HOST . '/' );
}

$form = new Socnet_Form ( 'utilities', 'POST' );




if (isset ( $this->params ['utilities'] )) {
	$new = $this->params ['utilities'] ['new'];
	unset ( $this->params ['utilities'] ['new'] );
	if ('' !== $new) {
		$utility = new Socnet_User_Utility ( );
		$utility->name = $new;
		$utility->save ();
		unset ( $utility );
	}
	if (sizeof ( $this->params ['utilities'] ) > 0) {
		foreach ( $this->params ['utilities'] as $key => $name ) {
			if ('' !== trim ( $name )) {
				$utility = new Socnet_User_Utility ( $key );
				$utility->name = $name;
				$utility->save ();
			} else {
				$utility = new Socnet_User_Utility ( $key );
				$utility->delete ();
			}
			unset ( $utility );
		}
	}
}
$utility = new Socnet_User_Utility ( );
$utility_array = $utility->setUtilityListAssoc ();
$this->_page->Template->assign ( 'utils', $utility_array );
$this->_page->setTitle ( 'Админка::Полезности' );
$this->_page->Template->assign ( 'form', $form );
$this->_page->Template->assign ( array ('bodyContent' => 'admin/utility.tpl' ) );