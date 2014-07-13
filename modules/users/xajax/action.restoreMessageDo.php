<?php
    
    if ( !$this->_page->_user->isAuthenticated() ) {
        $this->_redirectToLogin();
    }    
    
    $objResponse = new xajaxResponse();
    $objResponse->addScript("MainApplication.hideAjaxMessage();");
    $report = '';
    if (is_numeric($messageId)) {
        $message = new Socnet_Message_Standard($messageId);
        if (($message) && ($message->getOwnerId() == $this->_page->_user->getId())) {
            if ($message->getFolder() == Socnet_Message_eFolders::TRASH ) $message->delete();
            else  $message->moveToTrash();  
            $report = 'Message deleted';
            $redirectUrl = $this->_page->_user->getUserPath('messagelist');
        }    
    }
    elseif (is_array($messageId)) {
        if ($messageId[0] != null) {
            $messageStandard = new Socnet_Message_Standard($messageId[0]);
        	$eFolders = new Socnet_Message_eFolders();
        	$folder = $eFolders->toString($messageStandard->getFolder());
        	if ($folder == 'trash') 
        		$report = 'Messages removed';
        	else $report = 'Messages deleted'; 
        	foreach ($messageId as $id){
        	    $message = new Socnet_Message_Standard($id);
        	    if (($message) && ($message->getOwnerId() == $this->_page->_user->getId())) {
            	    if ($message->getFolder() == Socnet_Message_eFolders::TRASH ) $message->delete();
                    else  $message->moveToTrash();
        	    }    
        	}
        	$redirectUrl = $this->_page->_user->getUserPath('messagelist/folder/'.$folder);
        }
        else {
            $report = 'no messages selected';
            $redirectUrl = '';
        }    
    }
    elseif (is_string($messageId)) {
        if ( $messageId == 'trash') {
        $messageManager = new Socnet_Message_List();
        $messageManager->setFolder(Socnet_Message_eFolders::toInteger($messageId));
        $messages = $messageManager->findAllByOwner($this->_page->_user->getId()); 
        if (count($messages)) {  
            $redirectUrl = $this->_page->_user->getUserPath('messagedelete/folder/trash');
            $report = 'Trash is empty now';
        }
        elseif (count($messages) == 0){
            $redirectUrl = '';
            $report = 'Trash is already empty';
        }
    }
        	
    }   
    $objResponse->showAjaxAlert($report);
    $objResponse->addRedirect($redirectUrl);
