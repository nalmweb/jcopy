<?php

    $objResponse = new xajaxResponse();             
    foreach ($messages_ids as $message_id)
    {
        $message = new Socnet_Message_Standard($message_id);
        if (!($message) || ($message->getOwnerId() != $this->_page->_user->getId())) {
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
        }
        
        $message = new Socnet_Message_Standard($message_id);
        if ($message->getIsRead() == '1') {
            $message->setIsRead('0');
            $message->update();
        }
    }
    $objResponse->addRedirect($url);