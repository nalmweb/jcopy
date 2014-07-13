<?php
 
    $objResponse = new xajaxResponse();
    $showing = true;
    $property = '{width:350, height: 100}';
    if (is_numeric($messageId)) {
        $this->_page->Template->assign('messageId', $messageId);
    	$template = 'users/messages/messages.popup/message_delete.tpl';
    	$capture = 'Delete Message';
    }
    elseif (is_array($messageId)) {
        if (count($messageId)>0) {
            if (count($messageId)>1) {
                $deleteQuestion = 'Are you sure you want to delete those messages?';	
            }
            elseif (count($messageId)==1) $deleteQuestion = 'Are you sure you want to delete this message?';	
        	$this->_page->Template->assign('messageId', implode(',', $messageId));
            $template = 'users/messages/messages.popup/messages_delete.tpl';     
            $this->_page->Template->assign('deleteQuestion', $deleteQuestion);
        }
        else {
            $template = 'users/messages/messages.popup/messages_empty.tpl';         
            $property = '{width:250, height: 90}';
        } 
        $capture = 'Delete Messages';
        
    }
    elseif (is_string($messageId)) {
        $this->_page->Template->assign('messageId', $messageId);
        //$template = 'users/messages/folder_delete.tpl';  
        
        $messageManager = new Socnet_Message_List();
        $messageManager->setFolder(Socnet_Message_eFolders::TRASH);
        $messages = $messageManager->findAllByOwner($this->_page->_user->getId());
        $capture = 'Empty Trash';
        $template = 'users/messages/messages.popup/empty_trash.popup.tpl';
        if ($showDialog == 'true' && count($messages)>0) {
            //$objResponse->addScript("MainApplication.hideAjaxMessage();");
            $redirectUrl = $this->_page->_user->getUserPath('messagedelete/folder/trash/activefolder/' . $messageId . '/');
            $report = 'Trash is empty now';
            $objResponse->showAjaxAlert($report);
            $objResponse->addRedirect($redirectUrl);  	
            $showing = false;
        }
        if (count($messages) == 0) {
            $property = '{width:250, height: 90}';
            $template = 'users/messages/messages.popup/trash_empty.tpl';
            $capture = 'Empty Trash';
        }        
    }
    if ($showing) {
        $objResponse->addAssign ( "ajaxMessagePanelTitle", "innerHTML", $capture ) ;
        $Content = $this->_page->Template->getContents ( $template ) ;
        $objResponse->addAssign ( "ajaxMessagePanelContent", "innerHTML", $Content ) ;
        $objResponse->addScript('MainApplication.showAjaxMessage(' . $property . ');');
    }
    
   
    

