<?php
  if (!$this->_page->_user->isAuthenticated()) {
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  } elseif (!$this->_page->_user->isAdmin()){
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  }
  
$this->_page->Xajax->registerUriFunction("changePropName", "/admin/changePropName/");
$this->_page->Xajax->registerUriFunction("changePropChar", "/admin/changePropChar/");
$this->_page->Xajax->registerUriFunction("deleteProp", "/admin/deleteProp/");
$this->_page->Xajax->registerUriFunction("addListData", "/admin/addListData/");
$this->_page->Xajax->registerUriFunction("addListDataDo", "/admin/addListDataDo/");
$this->_page->Xajax->registerUriFunction("addPropertyValue", "/admin/addPropertyValue/");
$this->_page->Xajax->registerUriFunction("addNewProperty", "/admin/addNewProperty/");
$this->_page->Xajax->registerUriFunction("addNewPropertyDo", "/admin/addNewPropertyDo/");
$this->_page->Xajax->registerUriFunction("setPropertyDesc", "/admin/setPropertyDesc/");

$propertyList = new Socnet_Catalog_Property_List();
$propertyList->returnAsAssoc( false );
$properties = $propertyList->getList();
//dump($properties[1]->getListData());
$this->_page->Template->assign('propList', $propertyList->getList());

$unitDemension = new Socnet_Catalog_UnitDimension_List();
$unitDemension->returnAsAssoc( true );
$unitDemensions = $unitDemension->getList();
$unitDemensions[0] = '--';
ksort($unitDemensions);
$this->_page->Template->assign('udList', $unitDemensions);

$propertyTypeList = new Socnet_Catalog_TypeProperty_List();
$propertyTypeList->returnAsAssoc( true );
$propertyTypeList = $propertyTypeList->getList();
$this->_page->Template->assign('propTypeList', $propertyTypeList);
$this->_page->Template->assign('SWFUploadID', session_id());

$this->_page->Template->assign('listData', new Socnet_Catalog_ListData_Item());
$this->_page->Template->assign('bodyContent', 'admin/catalog/properties.settings.tpl');
        $js="<script language='javascript' src='/js/window_lib.js'></script> ".
            "<script language='javascript'src='/js/window_ext.js'></script>";
$this->_page->Template->assign('js', $js);

$this->_page->Template->assign('menuTab','catalog');
$this->_page->Template->assign('menuPodTab','propertiesS');
?>