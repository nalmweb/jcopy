<?php
$objResponse = new xajaxResponse();

$propertyTypeList = new Socnet_Catalog_TypeProperty_List();
$propertyTypeList->returnAsAssoc( true );
$propertyTypeList = $propertyTypeList->getList();
$this->_page->Template->assign('propTypeList', $propertyTypeList);

$unitDemension = new Socnet_Catalog_UnitDimension_List();
$unitDemension->returnAsAssoc(true);
$unitDemensions = $unitDemension->getList();
$unitDemensions[0] = '--';
ksort($unitDemensions);

$this->_page->Template->assign('udList', $unitDemensions);
$Content = $this->_page->Template->getContents('admin/catalog/newProperty.tpl');
$objResponse->addAssign("ajaxContent", "innerHTML", $Content);
$objResponse->addScript("openMyDialog('ajaxContent');");
