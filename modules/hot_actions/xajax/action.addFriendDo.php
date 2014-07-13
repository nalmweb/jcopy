<?php
$objResponse = new xajaxResponse();
$objResponse->addAlert("Несуществующий user_id = " .$user_id);
return $objResponse;
 
if (null !== $user_id)
{
    //if(Socnet_User::isUserExists('id', floor($user_id)))
    if(Socnet_User::isUserExists('id', $user_id ))
    {
        if($_SESSION['user_id'] !== $user_id)
        {
            $oUser = new Socnet_User('id', $user_id);
            $sendRequest = false;
            $sendAgain=false;
            if (false === $sendAgain) {
                $oFriendsRequests = new Socnet_User_Friend_Request_List();
                if ($oFriendsRequests->setSenderId($this->_page->_user->getId())->setRecipientId($user_id)->getCount())
                {
                  $this->_page->Template->assign('alredySent', 1);
                  $sendRequest = false;
                }
                else{
                   $sendRequest = true;
                }
            }
            else{
               $sendRequest = true;
            }
            //$objResponse->addAlert("sendReq = ".$sendRequest);
            //return $objResponse;
            if ($sendRequest)
            {
                $oFriends = new Socnet_User_Friend_Request_Item();
                $oFriends->setSenderId($this->_page->_user->getId());
                $oFriends->setRecipientId($user_id);
                $oFriends->setRequestDate(time());
                if ($oFriends->save()) {
                    //  Send message
                    $mail = new Socnet_Mail_Template('template_key', 'USERS_FRIEND_INVITE');
                    $mail->setSender($this->_page->_user);
                    $mail->addRecipient(new Socnet_User('id', $user_id));
                    $mail->sendToPMB(true);
                    $mail->sendToEmail(true);
                    $mail->addParam('message', $message);
                    $mail->send();
                    $oFriends->addRelation($mail->message);
                    //$objResponse->addScript("MainApplication.hideAjaxMessage();");
                    //$objResponse->showAjaxAlert($infoMessage);
                }
                $objResponse->addScript("closeDialog()");
                $infoMessage="Приглашение отправлено";
                $objResponse->addAlert($infoMessage);
                return $objResponse;
            }
            else
            {
                //$objResponse->addAssign("ajaxMessagePanelTitle", "innerHTML", "Add to friends");
                //$this->_page->Template->assign('friend', $oUser);
                //$Content = $this->_page->Template->getContents('users/addfriend.popup.tpl');
                //$objResponse->addAssign("ajaxMessagePanelContent", "innerHTML", $Content);
                //$objResponse->addScript('MainApplication.showAjaxMessage();');
            }
        }
        else
        {
            //1 $objResponse->addRedirect(BASE_HTTP_HOST); 
            $infoMessage="else 1";
            $objResponse->addAlert($infoMessage);
            return $objResponse;
        }
    } 
    else
    {
       $infoMessage="else 1";
       $objResponse->addAlert($infoMessage);
       return $objResponse;
       //$objResponse->addRedirect(BASE_HTTP_HOST);
    }
}
$objResponse->addAlert("Несуществующий user_id = " .$user_id);
?>