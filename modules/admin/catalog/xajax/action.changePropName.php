<?php
  if (!$this->_page->_user->isAuthenticated()) {
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  } elseif (!$this->_page->_user->isAdmin()){
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  }
    $objResponse = new xajaxResponse();
    
    if ( null !== $id ) {
        $oProperty = new Socnet_Catalog_Property_Item( $id );
        $oProperty->setName($value);
        $oProperty->save();
    }
    $objResponse->addRedirect(BASE_URL. '/admin/catalogPropertiesSettings/');
?>