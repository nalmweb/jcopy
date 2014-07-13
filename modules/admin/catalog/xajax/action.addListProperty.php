<?php
    $objResponse = new xajaxResponse();
    
    if ( null !== $propertyId ) {
        $list = new Socnet_Catalog_ListData_List( $propertyId );
        $list->returnAsAssoc();
        $this->_page->Template->assign('values',$list->getList());
        $this->_page->Template->assign('prop_id', $propertyId );
        
        $Content = $this->_page->Template->getContents ( 'admin/catalog/changeListData.tpl' );
        $objResponse->addAssign( "ajaxContent", "innerHTML", $Content );
        $objResponse->addScript("openMyDialog('ajaxContent');");
        
        
    }