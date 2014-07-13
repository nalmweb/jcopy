<?php
    $objResponse = new xajaxResponse();
    if (count($messageId)>0) {
        $result = true;
        foreach($messageId as $message_id) {
            $message = new Socnet_Message_Standard($message_id);
            if (($message) && ($message->getOwnerId() == $this->_page->_user->getId())) {
            	$result = $result && $message->recovery();
            }
        }
        if ($result) {
            $report = "restored";
        }
        else {
            $report = "not restored";
        }
        $objResponse->showAjaxAlert($report);
        $objResponse->addRedirect(LOCALE . '/messagelist/folder/trash/');
    }
    else {
        $property = '{width:250, height: 90}';
        $objResponse->addAssign ( "ajaxMessagePanelTitle", "innerHTML", "Restore Message" ) ;
        $template = 'users/messages/messages.popup/messages_empty.tpl';         
        $Content = $this->_page->Template->getContents ( $template ) ;
        $objResponse->addAssign ( "ajaxMessagePanelContent", "innerHTML", $Content ) ;
        $objResponse->addScript('MainApplication.showAjaxMessage(' . $property . ');');
    } 
    


