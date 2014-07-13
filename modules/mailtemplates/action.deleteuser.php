<?php

if (!Socnet_Access::hasAccess($this->_page->_user->id, null, 'mailtemplates','settings','delete')){
    $this->_redirectError('ACCESS DENIED');
}

Socnet_Access::removeRole($this->params['id'], 'Mail Templates Admin');

$this->_redirect('/settings/');
