<?php
  if (!$this->_page->_user->isAuthenticated()) {
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  } elseif (!$this->_page->_user->isAdmin()){
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  }
    $objResponse = new xajaxResponse();

    $objResponse->addClear('prop_block', 'InnerHTML');
    $form = new Socnet_Form('changeValues'. 'POST');
    $this->_page->Template->assign('form',$form);
    
    $categories = new Socnet_Catalog_Category_List();
    $categories->returnAsAssoc();
    $this->_page->Template->assign('categories',$categories->getList());  
      
    $propertyList = new Socnet_Catalog_Property_List();
    $propertyList->returnAsAssoc( false );
    $aPropertyList = $propertyList->getList();
    
    $this->_page->Template->assign('propList',$aPropertyList);

    $model = new Socnet_Catalog_Model_Item( $modelId );
    
    $tmpProps = array();
    foreach ( $model->getProperties() as $key => $val ) {
       $tmpProps[ $val->getIdProperty() ] = $val; 
    }

    $propertyList->returnAsAssoc(true);
    $taProp = $propertyList->getList();
    foreach ( $taProp as $key => $v ) {
        if ( isset($tmpProps[$key] ) ) {
            $taProp[$key] = $tmpProps[$key];
        } else {
            $tmp = new Socnet_Catalog_Model_Property_Item();
            //$tmp->setValue('');
            $tmp->setIdProperty( $key );
            $taProp[$key] = $tmp;
        }
    }

    $model->setProperties($taProp);

    $this->_page->Template->assign('modelGod', $model );
    $this->_page->Template->assign('tableValueCheck', 'id_model');
    
    $objResponse->addScript("document.getElementById('prop_block').style.display = 'block'");
    $output = $this->_page->Template->getContents ( 'admin/catalog/changePropertiesValues.tpl' ) ;

    //print_f($output,true);

    $objResponse->addAssign ( 'prop_block', 'innerHTML', $output ) ;
?>