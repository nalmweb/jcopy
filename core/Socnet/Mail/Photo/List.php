<?php
/*
 * Created on 03.06.2008
 * 
 */ 
 class Socnet_Mail_Photo_List extends Socnet_Abstract_List 
 {
   private $item_id; 
   private $m_table = "mail__photos";
   public $templateKey;
 	
   public function getList()
   {
 		$query = $this->_db->select(); //
        
        if ( $this->isAsAssoc() )
        {
            $fields = array();
            $fields[] = ( $this->getAssocKey() === null ) ? 'id' : $this->getAssocKey();
            $query->from($this->m_table,$fields);  
        }
        else{
            $query->from($this->m_table, 'id');
        }
        
        if(null !== $this->getItemId()){        
          $query->where( 'item_id = ?', $this->item_id );
        }
        
        $items = array();
        if ( $this->isAsAssoc()){
            $items = $this->_db->fetchPairs($query);
        }
        else
        {
           $items = $this->_db->fetchAll($query);
           foreach ( $items as &$item ){
           	 $item = new Socnet_Mail_Photo_Item($item['id']);
           }
        }
        return $items;
 	}
 	
 	// 
 	public function setItemId($key){
 		$this->item_id=$key;
 	}
 	
 	public function getItemId(){ return $this->item_id; }
 	
 	// 
 	public function getCount(){
 	  
 	}
 }
?>