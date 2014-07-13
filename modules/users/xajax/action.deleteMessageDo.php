<?php
    
    if ( !$this->_page->_user->isAuthenticated() ) {
        $this->_redirectToLogin();
    }    
    $objResponse = new xajaxResponse();
    $objResponse->addScript("MainApplication.hideAjaxMessage();");
    $report = '';
    $redirectUrl = '';
//    if (is_integer($messageId)) {
//        $message = new Socnet_Message_Standard($messageId);
//        if (($message) && ($message->getOwnerId() == $this->_page->_user->getId())) {
//            if ($message->getFolder() == Socnet_Message_eFolders::TRASH ) $message->delete();
//            else  $message->moveToTrash();  
//            $report = 'Message deleted';
//            $redirectUrl = $this->_page->_user->getUserPath('messagelist');
//        }    
//    }
    if (is_array($messageId)) {
        if ($messageId[0] != null) {
            $messageStandard = new Socnet_Message_Standard($messageId[0]);
        	$eFolders = new Socnet_Message_eFolders();
        	$folder = $eFolders->toString($messageStandard->getFolder());
        	if (count($messageId)>1) {
        		$messageText = 'Сообщения';
        	}
        	else {
        		$messageText = 'Сообщение';
        	}
        	if ($folder == 'trash')
        		$report =  $messageText . ' удалено';
        	
        	$deletedCount = 0;
        	
        	foreach ($messageId as $id){
        	    $message = new Socnet_Message_Standard($id);
        	    if (($message) && ($message->getOwnerId() == $this->_page->_user->getId())) {
            	    if ($message->getFolder() == Socnet_Message_eFolders::TRASH ) { 
            	       if ($message->delete()) $deletedCount++;
            	    }
                    else  {
                       if ($message->moveToTrash()) $deletedCount++;
                    }
        	    }    
        	}
        	
        	if ($deletedCount == 0) $report = "Can't remove message";
        	
        	$redirectUrl = $this->_page->_user->getUserPath('messagelist/folder/'.$folder);
        }
        else {
            $report = 'no messages selected';
            $redirectUrl = '';
        }    
    }
   
    $objResponse->showAjaxAlert($report);
    $objResponse->addRedirect($redirectUrl);   	
   
    
