<?php
class Socnet_User_List extends Socnet_Abstract_List 
{
	private $randomCount;
	
	private $status;
	
	/**
	 * @return unknown
	 */
	public function getRandomCount() {
		return $this->randomCount;
	}
	
	/**
	 * @param unknown_type $randomCount
	 */
	public function setRandomCount($randomCount) {
		$this->randomCount = $randomCount;
		return $this;
	}
	
	public function setStatus($status){
		$this->status=$status;	
	}
	public function getStatus(){
		return $this->status;
	}	
	
	public function getList()
    {
        $query = $this->_db->select();
        if ( $this->isAsAssoc() ) {
            $fields = array();
            $fields[] = ( $this->getAssocKey() === null ) ? 'id' : $this->getAssocKey();
            $fields[] = ( $this->getAssocValue() === null ) ? 'login' : $this->getAssocValue();
            $query->from('user', $fields);  
        } else {
            $query->from('user', 'id');
        }
        if(null !== $this->getStatus()){
         	$this->addWhere('status=?',$this->getStatus());		
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
            
            if ( null !== $this->getRandomCount() ) {
            	$items = array_flip( $items );
            	$items = array_rand( $items, $this->getRandomCount() );
            }
            	
            foreach ( $items as &$item ) $item = new Socnet_User( 'id', $item );
        }
        return $items;       
    }

    public function getCount()
    {
        $query = $this->_db->select();
        $query->from('user', 'COUNT(*)');
        if ( $this->getWhere() ) $query->where($this->getWhere());
        return $this->_db->fetchOne($query);
    }
}
?>
