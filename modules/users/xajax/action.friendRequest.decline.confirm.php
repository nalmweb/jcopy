<?php

    if (null == $redirect) {
        $header = "Decline Requests";
    } elseif ('sent' == $redirect) {
    	$redirect = ', \''.$redirect.'\'';
    	$header = "Delete Requests";
    }
    
    if ('all' == $requestId) {
    	$requestId = '\''. $requestId. '\'';
    }
    
    $objResponse = new xajaxResponse();    
    $objResponse->addAssign ( "ajaxMessagePanelTitle", "innerHTML", $header ) ;
    $this->_page->Template->assign('requestId', $requestId);
    $this->_page->Template->assign('redirect', $redirect);
    $Content = $this->_page->Template->getContents ( 'users/friends_declineConfirm.tpl' ) ;
    $objResponse->addAssign ( "ajaxMessagePanelContent", "innerHTML", $Content ) ;
    $objResponse->addScript('MainApplication.showAjaxMessage();');
?>