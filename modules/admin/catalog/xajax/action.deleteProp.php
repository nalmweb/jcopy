<?php
  if (!$this->_page->_user->isAuthenticated()) {
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  } elseif (!$this->_page->_user->isAdmin()){
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  }

  $objResponse = new xajaxResponse();
  if ( Null !== $id ) {
      $prop = new Socnet_Catalog_Property_Item( $id );
      $prop->delete();
      $objResponse->addRedirect(BASE_URL. '/admin/catalogPropertiesSettings/');
  }
?>