<?php
/**
 * Socnet FRAMEWORK
 * @package Socnet_User_Friend
 * @copyright Copyright (c) 2006
 */
class Socnet_User_Friend_Item extends Socnet_Data_Entity
{
    private $userId;
    private $friendId;
    private $createdDate;
    private $friend;
    /**
     * Class constructor
     *
     * @param int|string $id1 is always users id
     * @param int|string $id2 is always frends id
     */
    function __construct ($user_id = null, $friend_id = null)
    {
        parent::__construct('user__friends');
        $this->addField('user_id', 'userId');
        $this->addField('friend_id', 'friendId');
        $this->addField('created', 'createdDate');
        
        if (null !== $user_id && null !== $friend_id) {
            $query = $this->_db->select();
            $what= $this->_db->quoteInto(
                                        array("IF (user_id = ?, user_id, friend_id) as user_id",
                                              "IF (user_id <> ?, user_id, friend_id) as friend_id",
                                              "created"), $user_id
                                        );          
            
            $query->from('user__friends', $what);
            
            $query->where('(user_id = ?', $user_id);
            $query->where('friend_id = ?)', $friend_id);
            $query->orwhere('(user_id = ?', $friend_id);
            $query->where('friend_id = ?)', $user_id);
                                
            $this->loadBySql($query);
        }
    }
    
    /**
     * Return date of creation
     * 
     * @return string
     */
    public function getCreatedDate ()
    {
        return $this->createdDate;
    }
    /**
     * Return friend id
     *
     * @return int
     */
    public function getFriendId ()
    {
        return $this->friendId;
    }
    /**
     * Return user id
     *
     * @return int
     */
    public function getUserId ()
    {
        return $this->userId;
    }
    /**
     * Set date of creation
     * 
     * @param string newVal
     */
    public function setCreatedDate ($newVal)
    {
        if (is_int($newVal))
            $newVal = date('Y-m-d H:i:s', $newVal);
        $this->createdDate = $newVal;
        return $this;
    }
    /**
     * Set friend Id
     * 
     * @param int
     */
    public function setFriendId ($newVal)
    {
        $this->friendId = $newVal;
        return $this;
    }
    /**
     * Set user id
     * 
     * @param int newVal
     */
    public function setUserId ($newVal)
    {
        $this->userId = $newVal;
        return $this;
    }
    /**
     * Return object of friend
     *
     * @return obj
     */
    public function getFriend ()
    {
        if (null !== $this->getFriendId() && null === $this->friend) {
            $this->setFriend();
        }
        return $this->friend;
    }
    /**
     * Set object of friend
     *
     * @return obj Socnet_User
     */
    public function setFriend ()
    {
        $this->friend = new Socnet_User('id', $this->getFriendId());
        return $this;
    }
    
    /**
     * Return true if users are friends else false
     *
     * @param int $user_id 
     * @param int $friend_id
     * @return boolean
     */
    static public function isUserFriend ($user_id = null, $friend_id = null)
    {
    	if (null !== $user_id && null !== $friend_id) {
            $_db = Zend::registry("DB");
        	$query = $_db->select();
            $query->from('user__friends', "COUNT(*)");
            $query->where('(user_id = ?', $user_id);
            $query->where('friend_id = ?)', $friend_id);
            $query->orwhere('(user_id = ?', $friend_id);
            $query->where('friend_id = ?)', $user_id);
    		if ( $_db->fetchOne($query) ) return true;
         }
    	
    	return false;
    }
      
    /**
     * Save users friends relations
     * replace save method from Socnet_Data_Entity
     *
     * @todo Мне этот вариант очень не нравится и желательно заменить save на стандартный, однако сейчас Data_Entity такую ситуацию не предусматривает
     */
    public function save ()
    {
        $row = array('user_id' => $this->getUserId() , 
                     'friend_id' => $this->getFriendId() , 
                     'created' => $this->getCreatedDate());
        $this->_db->insert('user__friends', $row);
    }
    /**
     * Delete users friends relations
     * replace delete method from Socnet_Data_Entity
     *
     * @todo Мне этот вариант очень не нравится и желательно заменить delete на стандартный, однако сейчас Data_Entity такую ситуацию не предусматривает
     * @return result
     */
    public function delete ()
    {
    	 $user_user = $this->_db->quoteInto('user_id = ?', $this->getUserId( ));
         $user_friend = $this->_db->quoteInto('user_id = ?', $this->getFriendId( ));
         $friend_user = $this->_db->quoteInto('friend_id = ?', $this->getUserId( ));
         $friend_friend = $this->_db->quoteInto('friend_id = ?', $this->getFriendId( ));
         $query = <<<_SQL
                    DELETE FROM user__friends
                   WHERE ($user_user AND $friend_friend) 
                         OR ($friend_user AND $user_friend)          
_SQL;
         return $this->_db->query($query);
    }
}
?>