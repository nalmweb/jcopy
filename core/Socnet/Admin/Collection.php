<?php
class Socnet_Admin_Collection extends Socnet_Data_Entity
{
    public function addRequestToNewBike( $data ) 
    {
        return $this->_db->insert('catalog__bikes_requests', 
                                   array(
                                   'user_id'           => $data['userId'],
                                   'request'           => $data['request'],
                                    )
                                                                    );
    }

    public static function getCustomBukeForUser( Socnet_User $user ) 
    {
        $db = Zend::registry("DB");
        $query = $db->select();
        $query->from( 'catalog__bikes_requests', 'request' );
        $query->where( 'user_id = ?', $user->getId() );
        //print $query->__toString();
        return $db->fetchOne($query);
    }
}
?>