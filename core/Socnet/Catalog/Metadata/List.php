<?php
class Socnet_Catalog_Metadata_List extends Socnet_Abstract_List 
{
    private $idTypeMetadata;
    
    /**
     * @return unknown
     */
    public function getIdTypeMetadata ()
    {
        return $this->idTypeMetadata;
    }
    /**
     * @param unknown_type $name
     */
    public function setIdTypeMetadata ($idTypeMetadata)
    {
        $this->idTypeMetadata = $idTypeMetadata;
        return $this;
    }
    
    public function getList()
    {
        $query = $this->_db->select();
        if ( $this->isAsAssoc() ) {
            $fields = array();
            $fields[] = ( $this->getAssocKey() === null ) ? 'id' : $this->getAssocKey();
            $fields[] = ( $this->getAssocValue() === null ) ? 'data' : $this->getAssocValue();
            $query->from('catalog__metadata', $fields);  
        } else {
            $query->from('catalog__metadata', 'id');
        }
        
        if ( null !== $this->getIdTypeMetadata() ) {
            $query->where('id_type_metadata = ?', $this->getIdTypeMetadata());
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
            foreach ( $items as &$item ) $item = new Socnet_Catalog_Type_Item($item);
        }
        return $items;       
    }
    
    public function getCount()
    {
        $query = $this->_db->select();
        $query->from('catalog__metadata', 'COUNT(*)');
        if ( null !== $this->getIdTypeMetadata() ) $query->where('id_type_metadata = ?', $this->getIdTypeMetadata());
        if ( $this->getWhere() ) $query->where($this->getWhere());
        return $this->_db->fetchOne($query);
    }
}
?>
