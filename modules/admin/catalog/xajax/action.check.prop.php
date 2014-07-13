<?php
  if (!$this->_page->_user->isAuthenticated()) {
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  } elseif (!$this->_page->_user->isAdmin()){
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  }
    $objResponse = new xajaxResponse();

    if ( null !== $id && null !== $view ) {
        $property = new Socnet_Catalog_Property_Item( $id );
        $setView = 'set'.$view.'View';
        $getView = 'get'.$view.'View';
        $property->$setView( abs( $property->$getView() - 1 ) );
        $property->save();
        $objResponse->addScript('document.getElementById("'.$view.$id.'").checked = '. $property->$getView() );
    }
?>