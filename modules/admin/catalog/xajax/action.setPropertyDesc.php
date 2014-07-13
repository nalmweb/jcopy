<?php
$objResponse = new xajaxResponse ( );

if (null !== $propertyId) {
	$prop = new Socnet_Catalog_Property_Item ( $propertyId );
	
	if (null !== $prop->getId () && null !== $data) {
		$prop->setDescription ( $data );
		$prop->save ();
		$objResponse->addScript ( "Dialog.cancelCallback();" );
		$objResponse->addRedirect ( '/admin/catalogPropertiesSettings/' );
	} else {
	    
	    $this->_page->Template->assign('desc', $prop->getDescription());
	    $this->_page->Template->assign('propertyId', $prop->getId());
		$Content = $this->_page->Template->getContents ( 'admin/catalog/setPropertyDescription.tpl' );
		$objResponse->addAssign ( "ajaxContent", "innerHTML", $Content );
		$objResponse->addScript ( "openMyDialog('ajaxContent');" );
	}

}