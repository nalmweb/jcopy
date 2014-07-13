<?php
class Socnet_Catalog_ListData_List extends Socnet_Abstract_List 
{
    private $idProperty;
    
    function __construct($propertyId = null ) {
        $this->_db = Zend::registry("DB");
        if ( null !== $propertyId ) {
            $this->setIdProperty($propertyId);
        }
    }
    
	/**
	 * @return unknown
	 */
	public function getIdProperty() {
		return $this->idProperty;
	}
	
	/**
	 * @param unknown_type $idProperty
	 */
	public function setIdProperty($idProperty) {
		$this->idProperty = $idProperty;
		return $this;
	}
	
       public function getList()
        {
            $query = $this->_db->select();
            if ( $this->isAsAssoc() ) {
                $fields = array();
                $fields[] = ( $this->getAssocKey() === null ) ? 'id' : $this->getAssocKey();
                $fields[] = ( $this->getAssocValue() === null ) ? 'name' : $this->getAssocValue();
                $query->from('catalog__data_list_property', $fields);  
            } else {
                $query->from('catalog__data_list_property', 'id');
            }
            
            if ( null !== $this->getIdProperty() ) {
                $query->where( 'id_property = ?', $this->getIdProperty() );
            }
           
            if ( $this->getWhere() ) $query->where( $this->getWhere() );
            
            if ( $this->getCurrentPage() !== null && $this->getListSize() !== null ) {
                $query->limitPage($this->getCurrentPage(), $this->getListSize());
            }
            if ( $this->getOrder() !== null ) {
                $query->order($this->getOrder());
            }
            //print $query->__toString(); exit;
            $items = array();
            if ( $this->isAsAssoc() ) {
                $items = $this->_db->fetchPairs($query);
            } else {
                $items = $this->_db->fetchCol($query);
                foreach ( $items as &$item ) $item = new Socnet_Catalog_ListData_Item( $item );
            }
            return $items;       
        }
    
    public function getCount()
    {
        $query = $this->_db->select();
        $query->from('catalog__model_property', 'COUNT(*)');
        if ( null !== $this->getIdModel()) $query->where('id_model = ?', $this->getIdModel() );
        if ( $this->getWhere() ) $query->where($this->getWhere());
        return $this->_db->fetchOne($query);
    }
}
?>
