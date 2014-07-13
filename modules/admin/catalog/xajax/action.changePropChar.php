<?php
  if (!$this->_page->_user->isAuthenticated()) {
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  } elseif (!$this->_page->_user->isAdmin()){
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  }

  $objResponse = new xajaxResponse();
  if ( Null !== $id && null !== $value && null !== $char ) {
      $prop = new Socnet_Catalog_Property_Item( $id );
      $refresh = false;
      switch ( $char ) {
          case 'ud' :
              if ( $value == 0 ) $value = new Zend_Db_Expr( 'null' );
              $prop->setIdUnitDimension( $value );
              break;
          case 'pt' :
              if ( $prop->getIdTypeProperty() == 3 ) $refresh = true; 
              $prop->setIdTypeProperty( $value );
              if ( $value == 3 ) $refresh = true;
              break;
          default: 
      }
      $prop->save();
      if ( $refresh ) $objResponse->addRedirect(BASE_URL. '/admin/catalogPropertiesSettings/');
  }
//  dump($id,$value,$char);
?>