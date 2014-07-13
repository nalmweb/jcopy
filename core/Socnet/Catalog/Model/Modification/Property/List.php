<?php
class Socnet_Catalog_Model_Modification_Property_List extends Socnet_Abstract_List
{
    private $idModelGod;
    private $idModification;
    private $idProperty;
    private $shortView;
    private $listView;
    private $fullView;
    private $bboardView;
	/**
	 * @return unknown
	 */
	public function getIdModelGod() {
		return $this->idModelGod;
	}
	
	/**
	 * @param unknown_type $idModelGod
	 */
	public function setIdModelGod($idModelGod) {
		$this->idModelGod = $idModelGod;
		return $this;
	}

    /**
     * @return unknown
     */
    public function getIdModification() {
        return $this->idModification;
    }

    /**
     * @param unknown_type $idModelGod
     */
    public function setIdModification($idModification) {
        $this->idModification = $idModification;
        return $this;
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
	
    
   /**
     * @return unknown
     */
    public function getBboardView ()
    {
        return $this->bboardView;
    }
    /**
     * @param unknown_type $bboardView
     */
    public function setBboardView ($bboardView = true)
    {
        $this->bboardView = $bboardView;
        return $this;
    }
    /**
     * @return unknown
     */
    public function getFullView ()
    {
        return $this->fullView;
    }
    /**
     * @param unknown_type $fullView
     */
    public function setFullView ($fullView = true)
    {
        $this->fullView = $fullView;
        return $this;
    }
    /**
     * @return unknown
     */
    public function getListView ()
    {
        return $this->listView;
    }
    /**
     * @param unknown_type $listView
     */
    public function setListView ($listView = true)
    {
        $this->listView = $listView;
        return $this;
    }
    /**
     * @return unknown
     */
    public function getShortView ()
    {
        return $this->shortView;
    }
    /**
     * @param unknown_type $shortView
     */
    public function setShortView ($shortView = true)
    {
        $this->shortView = $shortView;
        return $this;
    }
	
    public function getList()
    {
        $query = $this->_db->select();
        if ( $this->isAsAssoc() ) {
            $fields = array();
            $fields[] = ( $this->getAssocKey() === null ) ? 'id' : $this->getAssocKey();
            $fields[] = ( $this->getAssocValue() === null ) ? 'value' : $this->getAssocValue();
            $query->from(array('cmp'=>'catalog__model_property'), $fields);  
        } else {
            $query->from(array('cmp'=>'catalog__model_property'), 'id');
        }
        $query->join(array('cp'=>'catalog__property'), 'cmp.id_property = cp.id' );
        if ( $this->getWhere() ) $query->where( $this->getWhere() );

        if ( null !== $this->getIdModelGod()) {
            $query->where('cmp.id_model_god = ?', $this->getIdModelGod() );
        }
        if ( null !== $this->getIdModification()) {
            $query->where('cmp.id_modification = ?', $this->getIdModification() );
        }
        if ( null !== $this->getIdProperty()) {
            $query->where('cmp.id_property = ?', $this->getIdProperty() );
        }        
        if ( $this->getBboardView() ) {
            $query->where( 'cp.bboard_view = 1');
        }else 
        
        if ( $this->getListView() ) {
            $query->where( 'cp.list_view = 1');
        } else 
        
        if ( $this->getShortView() ) {
            $query->where( 'cp.short_view = 1');
        } else
        
        if ( $this->getFullView() ) {
            $query->where( 'cp.full_view = 1');
        }
        
        if ( $this->getCurrentPage() !== null && $this->getListSize() !== null ) {
            $query->limitPage($this->getCurrentPage(), $this->getListSize());
        }
        if ( $this->getOrder() !== null ) {
            $query->order($this->getOrder());
        }
        //print $query->__toString();exit;
        $items = array();
        if ( $this->isAsAssoc() ) {
            $items = $this->_db->fetchPairs($query);
        } else {
            $items = $this->_db->fetchCol($query);
            foreach ( $items as &$item ) $item = new Socnet_Catalog_Model_Property_Item($item);
        }
        return $items;       
    }
    
    public function getCount()
    {
        $query = $this->_db->select();
        $query->from(array('cmp'=>'catalog__model_property'), 'COUNT(cmp.id)');
        $query->join(array('cp'=>'catalog__property'), 'cmp.id_property = cp.id', array() );
        if ( $this->getWhere() ) $query->where( $this->getWhere() );
        if ( null !== $this->getIdModelGod()) {
            $query->where('cmp.id_model_god = ?', $this->getIdModelGod() );
        }
        if ( null !== $this->getIdProperty()) {
            $query->where('cmp.id_property = ?', $this->getIdProperty() );
        }        
        if ( $this->getBboardView() ) {
            $query->where( 'cp.bboard_view = 1');
        }elseif ( $this->getListView() ) {
            $query->where( 'cp.list_view = 1');
        } elseif ( $this->getShortView() ) {
            $query->where( 'cp.short_view = 1');
        } elseif ( $this->getFullView() ) {
            $query->where( 'cp.full_view = 1');
        }
        return $this->_db->fetchOne($query);
    }
}
?>
