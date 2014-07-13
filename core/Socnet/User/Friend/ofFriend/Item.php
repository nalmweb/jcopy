<?php

/**
 * Socnet FRAMEWORK
 * @package Socnet_User_Friend
 * @copyright Copyright (c) 2006
 */
class Socnet_User_Friend_ofFriend_Item extends Socnet_User_Friend_Item {

    /**
     * Return true if user is friend of friend else false
     *
     * @param int $user_id 
     * @param int $friend_id
     * @return boolean
     * @author Eugene Kirdzei
     */
    static public function isUserFriendOfFriend ($user_id = null, $friend_id = null)
    {
        if (null !== $user_id && null !== $friend_id) {
            $_db = Zend::registry("DB");
            $user_userId = $_db->quoteInto('user_id = ?', $user_id);
            $friend_userId = $_db->quoteInto('friend_id = ?', $user_id);
            $friend_friendId = $_db->quoteInto('friend_id = ?', $friend_id);
            $user_friendId = $_db->quoteInto('user_id = ?', $friend_id);
            $queryStr = <<<_SQL
                    SELECT COUNT( * )
                    FROM user__friends
                    WHERE ( user_id IN (
                                        SELECT IF( $user_userId, friend_id, user_id )
                                        FROM user__friends
                                        WHERE ( $user_userId OR $friend_userId)
                                       ) 
                            AND $friend_friendId
                          )
                    OR   ( friend_id IN (
                                        SELECT IF( $user_userId, friend_id, user_id )
                                        FROM user__friends
                                        WHERE ( $user_userId OR $friend_userId)
                                       ) 
                           AND $user_friendId
                         )
_SQL;
            if ( $_db->fetchOne($queryStr) ) return true;
         }
        
        return false;
    }
	
	
}

?>
