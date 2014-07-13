<?php
class Socnet_User_Avatar_List extends Socnet_Abstract_List 
{
	/**
	 * user id
	 */
	private $_userId;
	

	public function setUserId($userId)
	{
		$this->_userId = $userId;
	}

	public function getUserId()
	{
		return $this->_userId; 
	}
	
    /**
     * Constructor
     */
	public function __construct($userId = null)
    {
        parent::__construct();
    	if ( $userId !== null ) $this->setUserId($userId);
    }

    public function getList()
    {
        $query = $this->_db->select();
        if ( $this->isAsAssoc() ) {
            $fields = array();
            $fields[] = ( $this->getAssocKey() === null ) ? 'ua.id' : $this->getAssocKey();
            $fields[] = ( $this->getAssocValue() === null ) ? 'ua.bydefault' : $this->getAssocValue();
            $query->from('user__avatars as ua', $fields);  
        } else {
            $query->from('user__avatars as ua', 'ua.id');
        }
        if ( $this->getWhere() ) $query->where($this->getWhere());
        if ( $this->getUserId() !== null ) {
            $query->where('ua.user_id = ?', $this->getUserId());
        }
        if ( $this->getCurrentPage() !== null && $this->getListSize() !== null ) {
            $query->limitPage($this->getCurrentPage(), $this->getListSize());
        }
        if ( $this->getOrder() !== null ) {
            $query->order($this->getOrder());
        }
        if ( $this->isAsAssoc() ) {
            $items = $this->_db->fetchPairs($query);
            $user = new Socnet_User('id', $this->_userId);
            
            if ($user->getAvatar()->getId() == 0) $items[0] = 1; else $items[0] = 0;
        } else {
            $items = $this->_db->fetchCol($query);
            $default = new Socnet_User_Avatar(0);
            $default->setUserId($this->_userId);
            
			$items1 = array($default);
            foreach ( $items as $key => $item ) {
            	$items1 = $items1 + array($key + 1 => new Socnet_User_Avatar($item));
            }
            $items = $items1;
        }
        return $items;
    }
    
    /**
     * return number of all items
     * @return int count
     */
    public function getCount()
    {
        $query = $this->_db->select();
        $query->from('user__avatars as ua', 'COUNT(ua.id)');
        if ( $this->getWhere() ) $query->where($this->getWhere());
        if ( $this->getUserId() !== null ) {
            $query->where('ua.user_id = ?', $this->getUserId());
        }
        return $this->_db->fetchOne($query);
    }
}