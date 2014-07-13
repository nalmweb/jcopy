<?php

$objResponse = new xajaxResponse ( ) ;
$form = new Socnet_Form('messageSendForm', 'post', 'javascript:void(0);');

if (isset($this->params['_sf__messageSendForm'])) {
    $_REQUEST['_sf__messageSendForm'] = $this->params['_sf__messageSendForm'];
}
$form->addRule('user_id', 'required', 'Invalid User Id');
$form->addRule('subject', 'required', 'Введите пожалуйста тему');
$form->addRule('message', 'required', 'Введите текст сообщения');
$form->addRule('subject', 'maxlength', 'Длина текста темы слишком большая (максимум 100 символов)', array('max' => 100));
$form->addRule('message', 'maxlength', 'Длина сообщиния слишком велика (максимум 65535 символов)', array('max' => 65535));

//dump($this->params);

/*if (empty($this->params['user_id']) || !($user = new Socnet_User('id', $this->params['user_id']))) {
    $form->addRule('custom_error', 'required', 'Invalid User Id');
}*/
/*if (empty($user_id) || !($user = new Socnet_User('id', $user_id))) {
    $form->addRule('custom_error', 'required', 'Несуществующий пользователь');
}*/

//if ($form->validate($this->params)) {
    $user = new Socnet_User('id', $user_id);
	$messageStandard = new Socnet_Message_Standard();
	$messageStandard->setSenderId($this->_page->_user->getId());
	$messageStandard->setOwnerId($user_id);
	$messageStandard->setSubject($subject);
	$messageStandard->setRecipientsListFromStringId($user_id);
	$messageStandard->setBody($message);
	$messageStandard->setIsRead(0);
	$messageStandard->setFolder(Socnet_Message_eFolders::INBOX);
	$messageStandard->save();
	
	$messageStandard->setOwnerId($this->_page->_user->getId());
	$messageStandard->setFolder(Socnet_Message_eFolders::SENT);
	$messageStandard->save();
	$objResponse->addAlert("Ваше сообщение отправлено");
	$objResponse->addScript("closeDialog()");
	//$objResponse->addScript ("MainApplication.hideAjaxMessage();" ) ;
	//$objResponse->showAjaxAlert('Sent') ;
// }
// show form again to resend the message
/*else
{
    if ($user_id) {
        $user = new Socnet_User('id', $user_id);
        $this->_page->Template->assign('form', $form);
        $this->_page->Template->assign($this->params);
        //$content = $this->_page->Template->getContents('users/messages/messages.popup/sendmessage.popup.tpl');
        $this->_page->Template->assign('user_id', $user_id);
		$Content =$this->_page->Template->getContents('users/messages/messages.popup/sendmessage.popup.tpl');
		$objResponse->addAssign( "ajaxContent", "innerHTML", $Content );
		$objResponse->addScript("closeDialog()");
		$objResponse->addScript("openMyDialog('ajaxContent')");
        //$objResponse->addClear("ajaxMessagePanelContent", "innerHTML");
        //$objResponse->addAssign("ajaxMessagePanelContent", "innerHTML", $content);
        //$objResponse->addScript('MainApplication.showAjaxMessage();');
    }
    else
    {
    	//$objResponse->addScript("MainApplication.hideAjaxMessage();");
    	//$objResponse->showAjaxAlert("Error");
    	$objResponse->addAlert("Что-то не так");
    }
 }   */ 
