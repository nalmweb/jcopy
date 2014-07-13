<?php
class Socnet_Catalog_GroupProperty_List extends Socnet_Abstract_List 
{
    public function getList()
    {
        $query = $this->_db->select();
        if ( $this->isAsAssoc() ) {
            $fields = array();
            $fields[] = ( $this->getAssocKey() === null ) ? 'id' : $this->getAssocKey();
            $fields[] = ( $this->getAssocValue() === null ) ? 'name' : $this->getAssocValue();
            $query->from('catalog__group_property', $fields);  
        } else {
            $query->from('catalog__group_property', 'id');
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
            foreach ( $items as &$item ) $item = new Socnet_Catalog_TypeProperty_Item($item);
        }
        return $items;       
    }
    
    public function getCount()
    {
        $query = $this->_db->select();
        $query->from('catalog__group_property', 'COUNT(*)');
        if ( $this->getWhere() ) $query->where($this->getWhere());
        return $this->_db->fetchOne($query);
    }
}
?>
