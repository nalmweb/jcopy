<?php
$objResponse = new xajaxResponse();
if (null !== $user_id)
{
    $form = new Socnet_Form('messageSendForm', 'post', 'javascript:void(0);');
    
    if (isset($params['_sf__messageSendForm']))
    {
        $_REQUEST['_sf__messageSendForm'] = $params['_sf__messageSendForm'];
    }
    $this->_page->Template->assign('form', $form);
    $this->_page->Template->assign('user_id', $user_id);
	$Content=$this->_page->Template->getContents('users/messages/messages.popup/sendmessage.popup.tpl');
	//$objResponse->addAlert($Content);
	$objResponse->addAssign("ajaxContent", "innerHTML",$Content);
	$objResponse->addScript("openMyDialog('ajaxContent')");
    // $objResponse->addClear("ajaxMessagePanelContent","innerHTML");
    // $objResponse->addAssign("ajaxMessagePanelContent","innerHTML",$Content); 
    // $objResponse->addScript('MainApplication.showAjaxMessage();');
}
//else $this->_redirectToLogin();
else 
	$objResponse->addRedirect('/');