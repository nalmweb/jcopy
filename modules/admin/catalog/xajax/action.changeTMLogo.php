<?php
$objResponse = new xajaxResponse();

$tm = new Socnet_Catalog_Trademark_Item( $markId );
    $this->_page->Template->assign('tm', $tm );

    
        $Content = $this->_page->Template->getContents ( 'admin/catalog/changeTMLogo.tpl' );
        $objResponse->addAssign( "ajaxContent", "innerHTML", $Content );
        $objResponse->addScript("openMyDialog('ajaxContent');");
        $objResponse->addScript('initSWFU();');
    
?>