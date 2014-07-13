<?php
    if ( $this->currentUser->id !== $this->_page->_user->id ) {
        if ( USE_USER_PATH ) {
            $this->_redirect($this->currentUser->user_adv_path.$this->_page->Locale.'/profile/');
        } else {
            $this->_redirect('/'.$this->_page->Locale.'/users/profile/');
        }
    }
    $this->_page->Template->assign('bodyContent', 'users/settings.tpl');
