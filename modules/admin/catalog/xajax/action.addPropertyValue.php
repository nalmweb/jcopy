<?php
  if (!$this->_page->_user->isAuthenticated()) {
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  } elseif (!$this->_page->_user->isAdmin()){
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  }
  
  $objResponse = new xajaxResponse();
  if ( null !== $params && is_array( $params )) {
      array_map('trim',$params);
      if ( isset( $params['prop_id'] ) ) {
          $propertyId = $params['prop_id'];
          unset($params['prop_id']);
          
          foreach ($params as $key => $value ) {
              if ( $key == 'new' ) {
          	    if ( $value !== '' ) {
          	        $DP = new Socnet_Catalog_ListData_Item();
                    $DP->setIdProperty( $propertyId );
                    $DP->setName( $value );
                    $DP->save();    
          	    }
          	} else {
          	    $DP = new Socnet_Catalog_ListData_Item( $key );
          	    if ( $value !== '' ) {   
                    $DP->setName( $value ); 
                    $DP->save();
          	    } else {
                    $DP->delete();      	        
          	    }
          	}
          }
          if ( null !== $action && $action == 'new' ) { 
              $objResponse->addScriptCall("Dialog.cancelCallback(); xajax_addListData($propertyId);");
          }  else {
              $objResponse->addRedirect( BASE_URL.'/admin/catalogPropertiesSettings/' ); 
          }
      }
  }
?>