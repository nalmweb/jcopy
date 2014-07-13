<?php
  if (!$this->_page->_user->isAuthenticated()) {
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  } elseif (!$this->_page->_user->isAdmin()){
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  }
  
    $this->_page->Xajax->registerUriFunction("checkProp", "/admin/checkProperty/");

    $propertyList = new Socnet_Catalog_Property_List();
    $propertyList->returnAsAssoc( false );

    $form = new Socnet_Form('viewProperties', 'POST');
    
    $this->_page->Template->assign('form', $form);
    $this->_page->Template->assign('propList', $propertyList->getList());
    $this->_page->Template->assign('bodyContent', 'admin/catalog/properties.view.tpl');

$this->_page->Template->assign('menuTab','catalog');
$this->_page->Template->assign('menuPodTab','propertiesV');

?>