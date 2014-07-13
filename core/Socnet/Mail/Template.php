<?php

class Socnet_Mail_Template extends Socnet_Data_Entity
{
    public $id;
    public $templateKey;
    public $creatorId;
    public $changerId;
    public $createDate;
    public $changeDate;
    public $description;
    public $content;
    public $message;

    private $Creator                = null;
    private $Changer                = null;
    private $_SendToEmail           = true;         
    private $_SendEmailTextPart     = true;         
    private $_SendEmailHTMLPart     = false;        
    private $_SendToPMB             = false;

    private $Sender                 = null;
    private $Recipients             = array();
    private $RecipientIDs           = array();
    private $Params                 = array();

    private $needLog                = false;

    private $_Attachments           = array();

    //useful for sending email only. defines charset to send message text. if null use default.
    private $_emailCharset = 'cp1251';

	public function __construct($key = null, $val = null)
	{
		parent::__construct('mail__templates');
		$this->addField('id');
		$this->addField('template_key', 'templateKey');
		$this->addField('creator_id', 'creatorId');
		$this->addField('changer_id', 'changerId');
		$this->addField('creation_date','createDate');
		$this->addField('change_date','changeDate');
		$this->addField('description');
		$this->addField('content');

	    if ( $key !== null && $val !== null ){
	       $this->pkColName = $key;
		   $this->loadByPk($val);
	    }
	}
	public function setCreator()
	{
       $this->Creator = new Socnet_User('id',$this->creatorId);
	}

	public function getCreator()
	{
	    if ( $this->Creator === null ) {
	        $this->setCreator();
	    }
	    return $this->Creator;
	}

	public function setChanger()
	{
       $this->Changer = new Socnet_User('id',$this->changerId);
	}

	public function getChanger()
	{
	    if ( $this->Changer === null ) {
	        $this->setChanger();
	    }
	    return $this->Changer;
	}

    public function setSender( $obj )
    {
        if ($obj instanceof Socnet_User ) {
            $this->Sender = $obj;
        } else throw new Zend_Exception("Incorrect Sender Object!");
    }

    public function getSender()
    {
        if ( $this->Sender === null ) throw new Zend_Exception("Sender is null!");
        return $this->Sender;
    }

    public function addRecipient( $obj )
    {
        if ($obj instanceof Socnet_User ) {
            $this->Recipients[]     = $obj;
            $this->RecipientIDs[]   = $obj->id;
        } else throw new Zend_Exception("Incorrect Recipient Object!");
    }

    public function addUserRecipientsFormString( $strEmails, $excludeIDs = null )
    {
        $excludeIDs = ( $excludeIDs === null || !is_array($excludeIDs) ) ? array() : $excludeIDs;

        $split = preg_split("/,|\n/im",$strEmails);
        if ( sizeof($split) != 0 ) {
            foreach ( $split as $ind => $email ) {
                if ( trim($email) != "" ) {
                    $_user = str_replace("\r","",trim($email));
                    if ( Socnet_User::isUserExists('login', $_user) ) {
                        $User = new Socnet_User('login', $_user);
                        if ( !in_array($User->getId(), $excludeIDs) ) $this->addRecipient($User);
                    } elseif ( Socnet_User::isUserExists('email', $_user) ) {
                        $User = new Socnet_User('email', $_user);
                        if ( !in_array($User->getId(), $excludeIDs) ) $this->addRecipient($User);
                    } elseif ( $this->isValidEmailAddress($_user) ) {
                        $User = new Socnet_User();
                        $User->setFirstname('Guest');
                        $User->setEmail($_user);
                        $this->addRecipient($User);
                    }
                }
            }
        }
    }

    public static function validateUserRecipientsFormString( $strEmails, $excludeIDs = null )
    {
        $returns = array();
        $returns['valid']['users']       = array();
        $returns['valid']['guests']      = array();
        $returns['invalid']['emails']    = array();
        $returns['invalid']['nicknames'] = array();

        $excludeIDs = ( $excludeIDs === null || !is_array($excludeIDs) ) ? array() : $excludeIDs;
        $excludeEmails = array();

        $split = preg_split("/,|\n/im",$strEmails);
        if ( sizeof($split) != 0 ) {
            foreach ( $split as $ind => $email ) {
                if ( trim($email) != "" ) {
                    $_user = str_replace("\r","",trim($email));
                    if ( false === strpos($_user, "@") )
                    {
                        if (Socnet_User::isUserExists('login', $_user))
                        {
                            $User = new Socnet_User('login', $_user);
                            if (!in_array($User->getId(), $excludeIDs) && !in_array($User->getEmail(), $excludeEmails))
                            {
                                $returns['valid']['users'][] = $User;
                                $excludeEmails[] = $User->getEmail();
                            }
                        }
                        else
                        {
                            $returns['invalid']['nicknames'][] = $_user;
                        }
                    }
                    else
                    {
                        if (Socnet_Mail_Template::validateEmailAddress($_user) && Socnet_User::isUserExists('email', $_user) )
                        {
                            $User = new Socnet_User('email', $_user);
                            if (!in_array($User->getId(), $excludeIDs) && !in_array($User->getEmail(), $excludeEmails))
                            {
                                $returns['valid']['users'][] = $User;
                                $excludeEmails[] = $User->getEmail();
                            }
                        }
                        elseif (Socnet_Mail_Template::validateEmailAddress($_user))
                        {
                            if (!in_array($_user, $excludeEmails))
                            {
                                $User = new Socnet_User();
                                $User->setFirstname('Guest');
                                $User->setLogin('Guest');
                                $User->setEmail($_user);
                                $returns['valid']['guests'][] = $User;
                                $excludeEmails[] = $_user;
                            }
                        }
                        else
                        {
                            $returns['invalid']['emails'][] = $_user;
                        }
                    }
                }
            }
        }
        return $returns;

    }

    public static function validateEmailAddress($value)
    {
        $regex = '/^((\"[^\"\f\n\r\t\v\b]+\")|([\w\!\#\$\%\&\'\*\+\-\~\/\^\`\|\{\}]+(\.[\w\!\#\$\%\&\'\*\+\-\~\/\^\`\|\{\}]+)*))@((\[(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))\])|(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))|((([A-Za-z0-9\-])+\.)+[A-Za-z\-]+))$/';
        if ( preg_match($regex, $value) ) {
            if (function_exists('checkdnsrr')) {
                $tokens = explode('@', $value);
                if (!(checkdnsrr($tokens[1], 'MX') || checkdnsrr($tokens[1], 'A'))) {
                    return false;
                }
            }
        } else {
            return false;
        }
        return true;
    }

    private function isValidEmailAddress($value)
    {
        $regex = '/^((\"[^\"\f\n\r\t\v\b]+\")|([\w\!\#\$\%\&\'\*\+\-\~\/\^\`\|\{\}]+(\.[\w\!\#\$\%\&\'\*\+\-\~\/\^\`\|\{\}]+)*))@((\[(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))\])|(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))|((([A-Za-z0-9\-])+\.)+[A-Za-z\-]+))$/';
        if ( preg_match($regex, $value) ) {
            if (function_exists('checkdnsrr')) {
                $tokens = explode('@', $value);
                if (!(checkdnsrr($tokens[1], 'MX') || checkdnsrr($tokens[1], 'A'))) {
                    return false;
                }
            }
        } else {
            return false;
        }
        return true;
    }

    public function getRecipients()
    {
        return $this->Recipients;
    }

    public function getRecipientIDs()
    {
        return $this->RecipientIDs;
    }

    public function addParam( $key, $value )
    {
        $this->Params[$key] = $value;
    }

    public function getParams()
    {
        return $this->Params;
    }

    public function sendToEmail( $bool )
    {
        $this->_SendToEmail = (bool) $bool;
    }

    public function sendEmailTextPart( $bool )
    {
        $this->_SendEmailTextPart = (bool) $bool;
    }

    public function sendEmailHTMLPart( $bool )
    {
        $this->_SendEmailHTMLPart = (bool) $bool;
    }

    public function sendToPMB( $bool )
    {
        $this->_SendToPMB = (bool) $bool;
    }

	public function send()
	{
	    if ( sizeof($this->getRecipients()) == 0 ) {
	        return false;
	    }
	    
	    if ( true == $this->_SendToEmail)
	    {
            require_once(ENGINE_DIR.'/htmlMimeMail5/htmlMimeMail5.php');
            $mail = new htmlMimeMail5();
            $cfgSite = new Zend_Config(new Zend_Config_Xml(CONFIG_DIR."cfg.site.xml", 'site'),true);
            if ( isset($cfgSite->smtp_method) && $cfgSite->smtp_method == 'smtp' ) {
                $mail->setSMTPParams($cfgSite->smtp_host, $cfgSite->smtp_port);
                $send_method = 'smtp';
            } else $cfgSite->smtp_method = 'mail';

            if (isset($this->_emailCharset)) {
                $mail->setTextCharset($this->_emailCharset);
                $mail->setHTMLCharset($this->_emailCharset);
                $mail->setHeadCharset($this->_emailCharset);
            }
	    }
	    
	    $smarty = new Smarty();
	    $smarty->compile_dir = DOC_ROOT.'/var/_compiled/site/';
	    $smarty->register_resource( "tpl", array( $this, "get_source", "get_timestamp", "get_secure", "get_trusted"));

        $smarty->assign('BASE_HTTP_HOST', BASE_HTTP_HOST);
        $smarty->assign('BASE_URL', BASE_URL);
        $smarty->assign('BASE_URL_SECURE', BASE_URL_SECURE);
        $smarty->assign('SITE_NAME_AS_STRING', SITE_NAME_AS_STRING);
        $smarty->assign('SITE_NAME_AS_DOMAIN', SITE_NAME_AS_DOMAIN);
        $smarty->assign('SITE_NAME_AS_FULL_DOMAIN', SITE_NAME_AS_FULL_DOMAIN);
        $smarty->assign('DOMAIN_FOR_EMAIL', DOMAIN_FOR_EMAIL);
        
        if ( sizeof($this->getParams()) != 0 ) $smarty->assign($this->getParams());

	    $sender = $this->getSender();

        $first = true;
	    foreach ( $this->getRecipients() as $recipient ) {
            $smarty->clear_assign('recipient');
            $smarty->assign('recipient', $recipient);
            $smarty->assign('sender', $sender);

            $smarty->assign('SenderLink', '');          //  @todo заменить на верный
            $smarty->assign('UnsubscribeLink', '');     //  @todo заменить на верный

            $smarty->fetch('tpl:'.$this->templateKey);
            /*
             * Send message to pmb
             */
            if ( true == $this->_SendToPMB ) {
                if ( $recipient->id !== null ) {    //  сообщение в PMB только зарегестрированным пользователям (или группам)
                    $message = new Socnet_Message_Standard();
                    $message->setSenderId($sender->id);
                    $pmb_subject   = trim($smarty->_smarty_vars['capture']['_subject_']);
                    $pmb_subject   = str_replace(array("\n", "\r"), "", $pmb_subject);
                    $message->setSubject($pmb_subject);
                    $message->setIsRead(0);
                    $message->setFolder(Socnet_Message_eFolders::INBOX);
                    $string = $message->arrayToString($this->getRecipientIDs());
                    $message->setRecipientsListFromStringId($string);
                    $message->setOwnerId($recipient->getId());
                    $message->setBody($smarty->_smarty_vars['capture']['_pmb_part_']);
                    if ( $first && false ) {
                        $messageOut = clone $message;
                        $messageOut->setRecipientsListFromStringId(null);
                        $messageOut->save();
                        $first = false;
                    }
                    $message->save();
                    $this->message = $message->getId();
                }
            }
            
            /*
             * Send message to email
             */
            if ( true == $this->_SendToEmail)
            {
                if ( $recipient instanceof Socnet_User ) $to = $recipient->login;
                else throw new Zend_Exception('Incorrect Recipient Type!');
        
                $from       = trim($smarty->_smarty_vars['capture']['_from_']);
                $from       = str_replace(array("\n", "\r"), "", $from);
                $subject    = trim($smarty->_smarty_vars['capture']['_subject_']);
                $subject    = str_replace(array("\n", "\r"), "", $subject);
                
                $mail->setText('');
                $mail->setHTML('');
                $mail->setFrom($from);
                $mail->setSubject($subject);

                //set additional headers
                if (isset($smarty->_smarty_vars['capture']['_to_']))
                    $mail->setHeader('To', $smarty->_smarty_vars['capture']['_to_']);

                if (isset($smarty->_smarty_vars['capture']['_date_']))
                    $mail->setHeader('Date', $smarty->_smarty_vars['capture']['_date_']);

                if ( true == $this->_SendEmailTextPart ) {
                	
               		/*$mail->setTextWrap(300);	
                    $mail->setText($smarty->_smarty_vars['capture']['_mail_text_part_']);*/
                    $body = $smarty->_smarty_vars['capture']['_mail_text_part_'];
                    $mail->setText($body);
                    //$params['content_type'] = 'text/plain';
					//$params['encoding']     = '7bit';
					//$text = $mail->addTextPart($body);
                }
                if ( true == $this->_SendEmailHTMLPart ) 
                {
                    $mail->setHTML($smarty->_smarty_vars['capture']['_mail_html_part_'],ATTACHMENT_DIR.'invite/');
                }
                
                if ( count($this->_Attachments) )
                {
                    foreach ($this->_Attachments as $attach)
                    {
                       /*$path = ATTACHMENT_DIR.$this->templateKey.'/'.$attach->originalName;
                       // ATTACHMENT_DIR.md5($attach->id).'.file'
                       $mail->addAttachment(new stringAttachment(file_get_contents($path), 
                       $attach->originalName, $attach->mimeType) );
                       echo $path." <br />";*/
                       $path = ATTACHMENT_DIR.$this->id.'/'.$attach->originalName;
                       $mail->addAttachment(new stringAttachment(file_get_contents($path), 
                       $attach->originalName, $attach->mimeType) );
                        /*$path = ATTACHMENT_DIR.$this->id.'/'.$attach->originalName;
						echo $path." <br />";*/ 
					    $mail->addEmbeddedImage(file_get_contents($path));                        					 
                    }
                }
                // dump($mail);
                $mail->send(array($to), $cfgSite->smtp_method, true);
            }
	    }
	}

	public function get_source($tpl_name, &$tpl_source, &$smarty)
	{
	    $tpl_source = $this->content;
	    return true;
	}

	public function get_timestamp($tpl_name, &$tpl_timestamp, &$smarty)
	{
	    // @todo изменить на дату

	    $tpl_timestamp = time();
	    return true;
	}

	public function get_secure($tpl_name, &$smarty)
	{
	    return true;
	}

	public function get_trusted($tpl_name, &$smarty)
	{
	}

    public static function sendPrivateMessage($templateFile, $senderType, $senderId, $recipientType = false, $recipients, $params, $saveSent = false)
    {
        if ( is_array($recipients) && count($recipients) ) {

            // @todo or inherits Socnet_View_Smarty ?

            $smarty = new Smarty();
            $smarty->compile_dir        = DOC_ROOT.'/var/_compiled/site/';
            $smarty->template_dir       = DOC_ROOT.'/templates/_messages/';

            foreach($params as $key=>$value) {
                $smarty->assign($key, $value);
            }

            $first = true;
            foreach($recipients as $recipientId) {
                $message = new Socnet_Message();
                $message->senderType        = $senderType;
                $message->senderId          = $senderId;
                // @todo - change to apropriate constant (with translation)
                $message->title             = "Сообщение";
                $message->isRead            = 0;
                $message->isReply           = 0;
                $message->isDelete          = 0;
                $message->isDraft           = 0;

                $message->recipientsList = $recipients;
                $message->recipientId = $recipientId;

                $message->message = $smarty->fetch($templateFile);
                // @todo - exchange with NOW()
                $message->date = strftime('%Y-%m-%d %H:%M:%S', time());

                // this code must be run only once per sending
                if ( $first && $saveSent ) {
                    $messageOut = clone $message;
                    $messageOut->recipientId = NULL;
                    $messageOut->save();
                    $first = false;
                }
                $message->save();
            }
            return $message->id;
        }
        else {
            return false;
        }

    }

    public static function sendEmail($templateFile, $senderType, $senderId, $recipients, $params, $saveSent)
    {
        // 98% copy of sendPriveMessage()
        if ((is_array($recipients)) && (count($recipients))) {
            // @todo or inherits Socnet_View_Smarty ?
            $smarty                 = new Smarty();
            $smarty->template_dir   = DOC_ROOT.'/../templates/_messages/';
            $smarty->compile_dir    = DOC_ROOT.'/../var/_compiled/site/';
            foreach($params as $key=>$value) {
                $smarty->assign($key, $value);
            }
            $first = true;
            foreach($recipients as $recipientId) {
                $message = new Socnet_Message();
                $message->senderType = $senderType;
                $message->senderId = $senderId;
                // @todo - change to apropriate constant (with translation)
                $message->title = "Сообщение";
                $message->isRead  =0;
                $message->isReply =0;
                $message->isDelete=0;
                $message->isDraft =0;

                $message->recipientsList = $recipients;
                $message->recipientId = $recipientId;

                $message->message = $smarty->fetch($templateFile);
                //dump($message->message);
                // @todo - exchange with NOW()
                $message->date = strftime('%Y-%m-%d %H:%M:%S', time());

                if (($first) && ($saveSent)) {
                    $messageOut = clone $message;
                    $messageOut->recipientId = NULL;
                    $messageOut->save();
                    $first = false;
                }
                //$message->save();
            }
            return $message->id;
        } else {
            return false;
        }
    }

    public function setAttachments($attachments)
    {
        $this->_Attachments = $attachments;
    }
    
    public function setEmailCharset($newCharacterSet)
    {
        $this->_emailCharset = $newCharacterSet;
    }
}
