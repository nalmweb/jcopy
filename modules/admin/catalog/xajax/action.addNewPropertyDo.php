<?php
$objResponse = new xajaxResponse ( );

if (null !== $data && '' !== $data ['name']) {
	$property = new Socnet_Catalog_Property_Item ( );
	$property->setDescription ( $data ['description'] );
	$property->setName ( $data ['name'] );
	$property->setIdUnitDimension ( $data ['ud'] );
	$property->setIdTypeProperty ( $data ['pt'] );
	$property->setIdTypeAuto ( 1 );
	$property->save ();
	$objResponse->addScript ( "Dialog.cancelCallback();" );
	$objResponse->addRedirect ( '/admin/catalogPropertiesSettings/' );
} else {
	$propertyTypeList = new Socnet_Catalog_TypeProperty_List ( );
	$propertyTypeList->returnAsAssoc ( true );
	$propertyTypeList = $propertyTypeList->getList ();
	$this->_page->Template->assign ( 'propTypeList', $propertyTypeList );
	
	$unitDemension = new Socnet_Catalog_UnitDimension_List ( );
	$unitDemension->returnAsAssoc ( true );
	$unitDemensions = $unitDemension->getList ();
	$unitDemensions [0] = '--';
	ksort ( $unitDemensions );
	$this->_page->Template->assign ( 'udList', $unitDemensions );
	
	$this->_page->Template->assign ( 'data', $data );
	$Content = $this->_page->Template->getContents ( 'admin/catalog/newProperty.tpl' );
	$objResponse->addAssign ( "ajaxContent", "innerHTML", $Content );
	$objResponse->addScript ( "openMyDialog('ajaxContent');" );
}