<?php
/**
 * Socnet FRAMEWORK
 * @package Socnet_User_Friend
 * @copyright Copyright (c) 2006
 */
class Socnet_User_Friend_Request_List extends Socnet_Abstract_List
{
   private $userId;
   private $recipientId;
   private $isSender;
   /**
     * Set sender id
     *
     * @param int newVal
     * @return self
     */
    public function setSenderId($newVal)
    {
        $this->userId = $newVal;
        return $this;
    }
    /**
     * Return sender id
     *
     * @return int
     */
    public function getSenderId()
    {
      return $this->userId;
    }
    
    /**
     * Set recipient id
     *
     * @param int $newVal
     * @return self
     */
    public function setRecipientId($newVal)
    {
        $this->recipientId = $newVal;
        return $this;
    }
    
    /**
     * Return recipient id
     *
     * @return int
     */
    public function getRecipientId()
    {
        return $this->recipientId;
    }

    /**
     * Sets isSender TRUE if user is sender
     * else FALSE
     *
     * @param boolean newVal
     * @return self
     */
    public function setIsSender($newVal)
    {
        $this->isSender = $newVal;
        return $this;
    }

    /**
     * Return "Is user sender"
     *
     * @return boolean
     */
    public function getIsSender()
    {
        return $this->isSender;
    }


    /**
     * Return list of friends requests
     *
     * @return array
     */
     public function getList()
     {
	 $query = $this->_db->select();

       if ( $this->isAsAssoc() )
  	 {
            $fields = array();
            if ($this->getIsSender()) {
                $fields[] = ( $this->getAssocKey() === null ) ? 'id' : $this->getAssocKey();
                $fields[] = ( $this->getAssocValue() === null ) ? 'recipient_id' : $this->getAssocValue();
            } else {
            	$fields[] = ( $this->getAssocKey() === null ) ? 'id' : $this->getAssocKey();
                $fields[] = ( $this->getAssocValue() === null ) ? 'sender_id' : $this->getAssocValue();
            }
            $query->from('user__friends_requests', $fields);
        } else {
            $query->from('user__friends_requests', 'id');
        }

        if ($this->getSenderId()) {
            $query->where('sender_id = ?', $this->getSenderId());
        } 
        
        if ($this->getRecipientId()) {
        	$query->where('recipient_id = ?', $this->getRecipientId());
        }

        if ( $this->getWhere() ) $query->where( $this->getWhere() );

        if ( $this->getCurrentPage() !== null && $this->getListSize() !== null ) {
            $query->limitPage($this->getCurrentPage(), $this->getListSize());
        }
        if ( $this->getOrder() !== null ) {
            $query->order($this->getOrder());
        }
        
        $items = array();
        if ( $this->isAsAssoc() ) {
            $items = $this->_db->fetchPairs($query);
        } else {
            $items = $this->_db->fetchCol($query);
            foreach ( $items as &$item ) $item = new Socnet_User_Friend_Request_Item($item);
        }
        return $items;
	}

	/**
	 * Return count of friends requests for user
	 *
	 * @return int
	 */
    public function getCount()
    {
	 $query = $this->_db->select();
       $query->from('user__friends_requests', 'COUNT(id)');

	 if ($this->getSenderId()) {
            $query->where('sender_id = ?', $this->getSenderId());
       } 
        
       if ($this->getRecipientId()) {
            $query->where('recipient_id = ?', $this->getRecipientId());
       }
        
       if ($this->getWhere()) $query->where( $this->getWhere() );
		return $this->_db->fetchOne($query);
    }

}
?>