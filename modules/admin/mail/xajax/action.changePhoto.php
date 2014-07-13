<?php
    $objResponse = new xajaxResponse();
    // $tm = new Socnet_Catalog_Trademark_Item( $markId );
    // $this->_page->Template->assign('tm', $tm );
    $common['type']    = Socnet_Photo_Config::$MAIL;
    $common['item_id'] = $item_id;
    $common['photo_id']= $photo_id;
    $this->_page->Template->assign('common',$common);
    $Content=$this->_page->Template->getContents ( 'admin/mail/mail.changePhoto.tpl' );
    
    $objResponse->addAssign("ajaxContent", "innerHTML", $Content );
    $objResponse->addScript("openMyDialog('ajaxContent');");
    $objResponse->addScript('initSWFU();');
?>