<?php
class Socnet_Catalog_Model_Year_List extends Socnet_Abstract_List 
{
    private $idModel;
    private $idModification;
    private $display;    
	
	/**
	 * @return unknown
	 */
	public function getIdModel () {
		return $this->idModel ;
	}
	
	/**
	 * @param unknown_type $idModel
	 */
	public function setIdModel ( $idModel ) {
		$this->idModel = $idModel ;
		return $this;
	}      

  	/**
	 * @return unknown
	 */
	public function getIdModification () {
		return $this->idModification ;
	}
	
	/**
	 * @param unknown_type $idModel
	 */
	public function setIdModification ( $idModification ) {
		$this->idModification = $idModification ;
		return $this;
	}
  
    /**
     * @return unknown
     */
    public function getDisplay() {
        return $this->display;
    }
    
    /**
     * @param unknown_type $display
     */
    public function setDisplay( $display = 1 ) {
        $this->display = $display;
        return $this;
    }
    	
    public function getList()
    {
        $query = $this->_db->select();
        if ( $this->isAsAssoc() ) {
            $fields = array();
            $fields[] = ( $this->getAssocKey() === null ) ? 'id' : $this->getAssocKey();
            $fields[] = ( $this->getAssocValue() === null ) ? 'god' : $this->getAssocValue();
            $query->from('catalog__model_god', $fields);  
        } else {
            $query->from('catalog__model_god', 'id');
        }
        if ( $this->getWhere() ) $query->where( $this->getWhere() );

        if ( null !== $this->getIdModel()) {
            $query->where('id_model = ?', $this->getIdModel() );
        }

        if ( null !== $this->getIdModification()) {
            $query->where('modification_id = ?', $this->getIdModification() );
        }
        
        if ( $this->getCurrentPage() !== null && $this->getListSize() !== null ) {
            $query->limitPage($this->getCurrentPage(), $this->getListSize());
        }
        if ( $this->getOrder() !== null ) {
            $query->order($this->getOrder());
        }
        
        if ( null !== $this->getDisplay() ) {
            $query->where('display = ?', $this->getDisplay());
        }
        //print $query->__toString();
        $items = array();
        if ( $this->isAsAssoc() ) {
            $items = $this->_db->fetchPairs($query);
        } else {
            $items = $this->_db->fetchCol($query);
            foreach ( $items as &$item ) $item = new Socnet_Catalog_Model_Year_Item($item);
        }
        return $items;       
    }
    
    public function getCount()
    {
        $query = $this->_db->select();
        $query->from('catalog__model', 'COUNT(*)');
        if ( null !== $this->getIdModel()) $query->where('id_model = ?', $this->getIdModel() );
        if ( $this->getWhere() ) $query->where($this->getWhere());
        return $this->_db->fetchOne($query);
    }
}
?>
