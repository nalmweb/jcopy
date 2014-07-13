<?php

/**
 * Socnet FRAMEWORK
 * @package Socnet_User_Friend
 * @copyright Copyright (c) 2006
 */
class Socnet_User_Friend_ofFriend_List extends Socnet_User_Friend_List 
{
    /**
     * retutn friends of friends
     *
     * @return array
     * @author Eugene Kirdzei
     */
    public function getList()
    {
    	$limit = '';
    	$user_userId = $this->_db->quoteInto('user_id = ?', $this->getUserId());
        $friend_userId = $this->_db->quoteInto('friend_id = ?', $this->getUserId());
        $what = $this->_db->quoteInto("IF (user_id = ?, friend_id, user_id)", $this->getUserId());
        
        if ( $this->getCurrentPage() !== null && $this->getListSize() !== null ) {
        	$page     = ($this->getCurrentPage() > 0)     ? $this->getCurrentPage()     : 1;
            $rowCount = ($this->getListSize() > 0) ? $this->getListSize() : 10;
            $limitCount  = (int) $rowCount;
            $limitOffset = (int) $rowCount * ($page - 1);
            $limit = "LIMIT $limitOffset, $limitCount";
        }
        
    	$query = <<<_SQL
                    SELECT DISTINCT $what
                    FROM user__friends
                    WHERE ( user_id IN (
                                        SELECT IF( $user_userId, friend_id, user_id )
                                        FROM user__friends
                                        WHERE ( $user_userId OR $friend_userId)
                                       ) 
                          )
                    OR   ( friend_id IN (
                                        SELECT IF( $user_userId, friend_id, user_id )
                                        FROM user__friends
                                        WHERE ( $user_userId OR $friend_userId)
                                       )
                         )
                    $limit
_SQL;
    	if ( $this->isAsAssoc() ) {
    	   $items = $this->_db->fetchCol($query);
    	} else {
    	   $items = $this->_db->fetchCol($query);
           foreach ( $items as &$item ) $item = new Socnet_User('id', $item);
    	}
        return $items;
    }
    
    /**
     * Return count of friends of friends
     *
     * @return int
     * @author Eugene Kirdzei
     */
    public function getCount()
    {
        $user_userId = $this->_db->quoteInto('user_id = ?', $this->getUserId());
        $friend_userId = $this->_db->quoteInto('friend_id = ?', $this->getUserId());
        $query = <<<_SQL
                    SELECT COUNT(*)
                    FROM user__friends
                    WHERE ( user_id IN (
                                        SELECT IF( $user_userId, friend_id, user_id )
                                        FROM user__friends
                                        WHERE ( $user_userId OR $friend_userId)
                                       ) 
                          )
                    OR   ( friend_id IN (
                                        SELECT IF( $user_userId, friend_id, user_id )
                                        FROM user__friends
                                        WHERE ( $user_userId OR $friend_userId)
                                       )
                         )
_SQL;
        return $this->_db->fetchOne($query);
    }
}

?>
