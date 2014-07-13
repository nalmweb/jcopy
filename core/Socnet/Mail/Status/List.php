<?php
class Socnet_Mail_Status_List extends Socnet_Abstract_List 
{
   private $m_table = "mail__templates";
   public $templateKey;
   
   public function getList(){
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
        
        if(null !== $this->getTemplateKey() ){        
          $query->where( 'template_key = ?', $this->templateKey );
        }
        
        $items = array();
        if ( $this->isAsAssoc()){
            $items = $this->_db->fetchPairs($query);
        }
        else
        {
           $items = $this->_db->fetchAll($query);
           //dump($items);
           //dump($query);
           foreach ( $items as &$item ){
           	 $item = new Socnet_Mail_Status_Item($item['id']);
           } 
           //dump($items);
        }
        return $items;
 	}
 	
 	// 
 	public function setTemplateKey($key){
 		$this->templateKey=$key;
 	}
 	
 	public function getTemplateKey(){ return $this->templateKey; }
 	
 	// 
 	public function getCount(){
 	  
 	}	
 }
?>
