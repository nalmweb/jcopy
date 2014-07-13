<?php
class Socnet_Catalog_Property_List extends Socnet_Abstract_List 
{
    private $idUnitDemension;
    private $idTypeProperty;
    private $shortView;
    private $listView;
    private $fullView;
    private $bboardView;
    private $idTypeAuto = 1;

    /**
	 * @return unknown
	 */
	public function getIdTypeProperty () {
		return $this->idTypeProperty ;
	}
    /**
	 * @param unknown_type $idTypeProperty
	 */
	public function setIdTypeProperty ( $idTypeProperty ) {
		$this->idTypeProperty = $idTypeProperty ;
		return $this;
	}
	
	/**
	 * @return unknown
	 */
	public function getIdUnitDemension () {
		return $this->idUnitDemension ;
	}

	public function setIdUnitDemension ( $idUnitDemension ) {
		$this->idUnitDemension = $idUnitDemension ;
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
    
    /**
     * @return unknown
     */
    public function getIdTypeAuto ()
    {
        return $this->idTypeAuto;
    }
    /**
     * @param unknown_type $idTypeAuto
     */
    public function setIdTypeAuto ($idTypeAuto)
    {
        $this->idTypeAuto = $idTypeAuto;
        return $this;
    }
    
    public function getList()
    {
        $query = $this->_db->select();
        if ( $this->isAsAssoc() ) {
            $fields = array();
            $fields[] = ( $this->getAssocKey() === null ) ? 'id' : $this->getAssocKey();
            $fields[] = ( $this->getAssocValue() === null ) ? 'name' : $this->getAssocValue();
            $query->from('catalog__property', $fields);  
        } else {
            $query->from('catalog__property', 'id');
        }
        
        $query->where('id_type_auto = ?', $this->getIdTypeAuto());
        
        if ( null !== $this->getIdUnitDemension() ) {
            $query->where( 'id_unit_demension = ?', $this->getIdUnitDemension() );
        }
        
        if ( null !== $this->getIdTypeProperty() ) {
            $query->where( 'id_type_property = ?', $this->getIdTypeProperty() );
        }
        
        if ( $this->getBboardView() ) {
            $query->where( 'bboard_view = 1');
        }else 
        
        if ( $this->getListView() ) {
            $query->where( 'list_view = 1');
        } else 
        
        if ( $this->getShortView() ) {
            $query->where( 'short_view = 1');
        } else
        
        if ( $this->getFullView() ) {
            $query->where( 'full_view = 1');
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
            foreach ( $items as &$item ) $item = new Socnet_Catalog_Property_Item( $item );
        }
        return $items;       
    }
    
    public function getCount()
    {
        $query = $this->_db->select();
        $query->from('catalog__property', 'COUNT(id)');
        $query->where('id_type_auto = ?', $this->getIdTypeAuto());
        if ( null !== $this->getIdUnitDemension() ) $query->where( 'id_unit_demension = ?', $this->getIdUnitDemension() );
        if ( null !== $this->getIdTypeProperty() )  $query->where( 'id_type_property = ?', $this->getIdTypeProperty() );
        if ( $this->getBboardView() )    $query->where( 'bboard_view = 1');
        elseif ( $this->getListView() )  $query->where( 'list_view = 1');
        elseif ( $this->getShortView() ) $query->where( 'short_view = 1');
        elseif ( $this->getFullView() )  $query->where( 'full_view = 1');
        if ( $this->getWhere() ) $query->where( $this->getWhere() );
        return $this->_db->fetchOne($query);
    }
}
?>
