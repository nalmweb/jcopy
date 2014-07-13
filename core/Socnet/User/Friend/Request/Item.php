<?php
/**
 * Socnet FRAMEWORK
 * @package Socnet_User_Friend
 * @copyright Copyright (c) 2006
 */

class Socnet_User_Friend_Request_Item extends Socnet_Data_Entity {
	
	private $id ;
	private $senderId ;
	private $recipientId ;
	private $requestDate ;
	
	private $messageId ;
	private $message ;
	private $sender ;
	private $recipient ;
	
	/**
	 * Class constructor
	 *
	 * @param int $id
	 */
	function __construct ( $id = null ) {
		parent::__construct ( 'user__friends_requests' ) ;
		$this->addField ( 'id' ) ;
		$this->addField ( 'sender_id', 'senderId' ) ;
		$this->addField ( 'recipient_id', 'recipientId' ) ;
		$this->addField ( 'request_date', 'requestDate' ) ;
		// $this->addField ( 'message' );
		
		if ($id !== null) {
			$this->pkColName = 'id' ;
			$this->loadByPk ( $id ) ;
		}
	}
	
	/**
	 * Set request id
	 * 
	 * @param int newVal
	 * 
	 */
	public function setId ( $newVal ) {
		$this->id = $newVal ;
		return $this ;
	}
	
	/**
	 * return request id
	 *
	 * @return int
	 */
	public function getId () {
		return $this->id ;
	}
	
	/**
	 * Return sender id
	 *
	 * @return int
	 */
	public function getSenderId () {
		return $this->senderId ;
	}
	
	/**
	 * 
	 * @param newVal
	 */
	public function setSenderId ( $newVal ) {
		$this->senderId = $newVal ;
		return $this ;
	}
	
	/**
	 * Return recipient id
	 *
	 * @return int
	 */
	public function getRecipientId () {
		return $this->recipientId ;
	}
	
	/**
	 * Set recipient id
	 * 
	 * @param int
	 */
	public function setRecipientId ( $newVal ) {
		$this->recipientId = $newVal ;
		return $this ;
	}
	
	/**
	 * Return message id
	 *
	 * @return int
	 */
	public function getMessageId () {
		if (null === $this->messageId) {
			$this->setMessageId () ;
		}
		return $this->messageId ;
	}
	
	/**
	 * Set message id
	 * 
	 * @param int
	 */
	public function setMessageId () {
		$query = $this->_db->select () ;
		$query->from ( 'requests__relations', 'message_id' ) ;
		$query->where ( 'request_id = ?', $this->getId () ) ;
		$this->messageId = $this->_db->fetchOne ( $query ) ;
		return $this ;
	}
	
	/**
	 * Return message object
	 *
	 * @return obj
	 */
	public function getMessage () {
		if (null === $this->message && null !== $this->getMessageId ()) {
			$this->setMessage () ;
		}
		return $this->message ;
	}
	
	/**
	 * Set message object
	 * 
	 * @param obj
	 */
	public function setMessage () {
		$this->message = new Socnet_Message_Standard ( $this->getMessageId () ) ;
		return $this ;
	}
	
	public function setMessageText($message)
	{
		$this->message = $message;
	}
	
	/**
	 * Return request date
	 *
	 * @return string
	 */
	public function getRequestDate () {
		return $this->requestDate ;
	}
	
	/**
	 * Set request date
	 * 
	 * @param int|string
	 */
	public function setRequestDate ( $newVal ) {
		if (is_int ( $newVal ))
			$newVal = date ( 'Y-m-d H:i:s', $newVal ) ;
		$this->requestDate = $newVal ;
		return $this ;
	}
	
	/**
	 * Return object of recipient
	 *
	 * @return obj Socnet_User
	 */
	public function getRecipient () {
		if (null !== $this->getRecipientId () && null === $this->recipient) {
			$this->setRecipient () ;
		}
		
		return $this->recipient ;
	}
	
	/**
	 * Set object of sender
	 *
	 * @return obj Socnet_User
	 */
	public function setRecipient () {
		$this->recipient = new Socnet_User ( 'id', $this->getRecipientId () ) ;
		return $this ;
	}
	
	/**
	 * Return object of sender
	 *
	 * @return obj Socnet_User
	 */
	public function getSender () {
		if (null !== $this->getSenderId () && null === $this->sender) {
			$this->setSender () ;
		}
		
		return $this->sender ;
	}
	
	/**
	 * Set object of sender
	 *
	 * @return obj Socnet_User
	 */
	public function setSender () {
		$this->sender = new Socnet_User ( 'id', $this->getSenderId () ) ;
		return $this ;
	}
	
    /**
     * Delete users friends requests
     * replace delete method from Socnet_Data_Entity
     *
     * @todo Мне этот вариант очень не нравится и желательно заменить delete на стандартный, однако сейчас Data_Entity такую ситуацию не предусматривает
     * @return result
     */
    public function deleteAll ()
    {
         $sender_sender = $this->_db->quoteInto('sender_id = ?', $this->getSenderId( ));
         $recipient_reciprent = $this->_db->quoteInto('recipient_id = ?', $this->getRecipientId( ));
         $recipient_sender = $this->_db->quoteInto('recipient_id = ?', $this->getSenderId( ));
         $sender_recipient = $this->_db->quoteInto('sender_id = ?', $this->getRecipientId( ));
         $query = <<<_SQL
                    DELETE FROM user__friends_requests
                    WHERE ($sender_sender AND $recipient_reciprent) 
                       OR ($recipient_sender AND $sender_recipient)          
_SQL;
         return $this->_db->query($query);
    }
    
    public function save()
    {
        parent::save();
        $this->addRelation($this->getId());
    }
    
    public function addRelation($messageId = null){
    	if ( null !== $messageId ) {
        return $query = $this->_db->insert('requests__relations', 
                                           array('request_id' => $this->getId(),
                                                 'message_id' => $messageId));
    	} 
    	
    	return false;
    }
}
?>