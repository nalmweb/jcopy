<?php

/**
 * Socnet FRAMEWORK
 * @package Socnet_User_Friend
 * @copyright Copyright (c) 2006
 * @author Eugene Kirdzei
 */

class Socnet_User_Friend_List extends Socnet_Abstract_List
{
	private $userId;
	private $countryIds;
	private $stateIds;
	private $cityIds;
	private $joinView;

	/**
     * Set variable $joinView on true if we add filter by any location
     * 
     * @param boolean
     * @author Eugene Kirdzei
     */
	public function setJoinView($newVal) 
	{
		$this->joinView = $newVal;
	}
	
   /**
     * Return true if we add filter by any location
     * 
     * @return boolean
     * @author Eugene Kirdzei
     */
    public function getJoinView() 
    {
        return $this->joinView;
    }
	
    /**
	 * Return user id
	 *
	 * @return int
	 * @author Eugene Kirdzei
	 */
	public function getUserId()
	{
		return $this->userId;
	}

	/**
	 * Set user id
	 * 
	 * @param int
	 * @author Eugene Kirdzei
	 */
	public function setUserId($newVal)
	{
		$this->userId = $newVal;
		return $this; 
	}
	
	/**
	 * Set country id for search
	 *
	 * @param array $newVal
	 * @return self
	 * @author Eugrnr Kirdzei
	 */
	public function setCountryIds($newVal)
	{
		if ( !is_array($newVal) ) {
			$newVal =  array($newVal);
		}
		$this->setJoinView( true );
		$this->countryIds = $newVal;
        return $this;
	}

	/**
	 * Return country id
	 *
	 * @return int
	 * @author Eugrnr Kirdzei
	 */
	public function getCountryIds()
	{
		return $this->countryIds;
	}
	
    /**
     * Set state id for search
     *
     * @param int $newVal
     * @return self
     * @author Eugrnr Kirdzei
     */
    public function setStateIds($newVal)
    {
        if ( !is_array($newVal) ) {
            $newVal =  array($newVal);
        }
    	$this->setJoinView( true );
    	$this->stateIds = $newVal;
        return $this;
    }

    /**
     * Return state id
     *
     * @return int
     * @author Eugrnr Kirdzei
     */
    public function getStateIds()
    {
        return $this->stateIds;
    }
	
    /**
     * Set city id for search
     *
     * @param int $newVal
     * @return self
     * @author Eugrnr Kirdzei
     */
    public function setCityIds($newVal)
    {
        if ( !is_array($newVal) ) {
            $newVal =  array($newVal);
        }
    	$this->setJoinView( true );
    	$this->cityIds = $newVal;
        return $this;
    }

    /**
     * Return city id
     *
     * @return int
     * @author Eugrnr Kirdzei
     */
    public function getCityIds()
    {
        return $this->cityIds;
    }    
    
    public function getOrederByName()
    {
    	return $this->orderByName;
    }
    
	/**
	 * Return list of friends
	 *
	 * @return array
	 * @author Eugene Kirdzei
	 */
	public function getList()
	{
		$query = $this->_db->select();
        $query->from('user__friends', array("IF (user_id = {$this->getUserId()}, friend_id, user_id) as friend_id"));
        /*
        if ( null !== $this->getJoinView() ) {
        	$query->join ('view_users__locations as vul', "vul.id = friend_id" );
        }
        */
        $query->where('(user_id = ?', $this->getUserId());
        $query->orWhere('friend_id = ?)', $this->getUserId());
/*
	    if ( null !== $this->getCountryIds()) {
            $query->where('vul.country_id IN (?)', $this->getCountryIds());
        }
        
        if ( null !== $this->getStateIds()) {
            $query->where('vul.state_id IN (?)', $this->getStateIds());
        }
        
        if ( null !== $this->getCityIds()) {
            $query->where('vul.city_id IN (?)', $this->getCityIds());
        }
    */    
        if ( $this->getWhere() ) $query->where( $this->getWhere() );
        
        if ( null !== $this->getCurrentPage() && null !== $this->getListSize() ) {
            $query->limitPage($this->getCurrentPage(), $this->getListSize());
        }

        if ( $this->getOrder() !== null ) {
            $query->order($this->getOrder());
        }
        
        $items = array();
        if ( $this->isAsAssoc() ) {
            $items = $this->_db->fetchCol($query);
        } else {
        $items = $this->_db->fetchCol($query);
            foreach ( $items as &$item ) {
                $item = new Socnet_User_Friend_Item($this->getUserId(),$item);
            }
        }
        
        return $items;          
	}

	/**
	 * Return count of friends
	 *
	 * @return int
	 * @author Eugene Kirdzei
	 */
	public function getCount()
	{
        $query = $this->_db->select();
        $query->from('user__friends', 'COUNT(*)');
	    if ( null !== $this->getJoinView() ) $query->join ( 'view_users__locations as vul', "vul.id = friend_id" );
        $query->where('(user_id = ?', $this->getUserId());
        $query->orWhere('friend_id = ?)', $this->getUserId());
	    if ( null !== $this->getCountryIds()) $query->where('vul.country_id IN (?)', $this->getCountryIds());
        if ( null !== $this->getStateIds())   $query->where('vul.state_id IN (?)', $this->getStateIds());
        if ( null !== $this->getCityIds())    $query->where('vul.city_id IN (?)', $this->getCityIds());
        if ( $this->getWhere() ) $query->where( $this->getWhere() );
        return $this->_db->fetchOne($query);
	}

}
?>