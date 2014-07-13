<?php
class Socnet_Catalog_Model_View_List extends Socnet_Abstract_List
{
    private $idModel;
    private $idTrademark;
    private $idCategory;
    private $viewMode;
    private $display;
   
    /**
     * @return unknown
     */
    public function getIdModel ()
    {
        return $this->idModel;
    }
    /**
     * @param unknown_type $idModel
     */
    public function setIdModel ($idModel)
    {
        $this->idModel = $idModel;
        return $this;
    }
    /**
     * @return unknown
     */
    public function getIdTrademark ()
    {
        return $this->idTrademark;
    }
    /**
     * @param unknown_type $idTrdemark
     */
    public function setIdTrademark ($idTrademark)
    {
        $this->idTrademark = $idTrademark;
        return $this;
    }
    /**
     * @return unknown
     */
    public function getIdCategory ()
    {
        return $this->idCategory;
    }
    /**
     * @param unknown_type $idTrdemark
     */
    public function setIdCategory ($idCategory)
    {
        $this->idCategory = $idCategory;
        return $this;
    }
    
    /**
     * @return unknown
     */
    public function getViewMode ()
    {
        return $this->viewMode;
    }
    /**
     * @param unknown_type $viewMode
     */
    public function setViewMode ($viewMode)
    {
        $this->viewMode = $viewMode;
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

    
    public function getList ()
    {
        $query = $this->_db->select();
        if ($this->isAsAssoc()) {
            $fields = array();
            $fields[] = ($this->getAssocKey() === null) ? 'id' : $this->getAssocKey();
            $fields[] = ($this->getAssocValue() === null) ? 'name' : $this->getAssocValue();
            $query->from('view__catalog_model_god', $fields);
        } else {
            $query->from('view__catalog_model_god', 'id');
        }
        if ($this->getWhere())
            $query->where($this->getWhere());
        if (null !== $this->getIdModel()) {
            $query->where('id_model = ?', $this->getIdModel());
        }
        if (null !== $this->getIdTrademark()) {
            $query->where('id_trademark = ?', $this->getIdTrademark());
        }
        if (null !== $this->getIdCategory()) {
            $query->where('id_category = ?', $this->getIdCategory());
        }
        
        if ( null !== $this->getDisplay() ) {
            $query->where('display = ?', $this->getDisplay());
        }
        
        if ($this->getCurrentPage() !== null && $this->getListSize() !== null) {
            $query->limitPage($this->getCurrentPage(), $this->getListSize());
        }
        
        if ($this->getOrder() !== null) {
            $query->order($this->getOrder());
        }
        //print $query->__toString();
        $items = array();
        if ($this->isAsAssoc()) {
            $items = $this->_db->fetchPairs($query);
        } else {
            $items = $this->_db->fetchCol($query);
            foreach ($items as &$item) {
                $item = new Socnet_Catalog_Model_View_Item('id', $item);
                if ( null !== $this->getViewMode() ) {
                    $item->setViewMode( $this->getViewMode() );
                }
            }
        }
        return $items;
    }
    public function getCount ()
    {
        $query = $this->_db->select();
        $query->from('view__catalog_model_god', 'COUNT(*)');
        if (null !== $this->getIdModel())
            $query->where('id_model = ?', $this->getIdModel());
        if (null !== $this->getIdTrademark())
            $query->where('id_category = ?', $this->getIdTrademark());
        if (null !== $this->getIdCategory())
            $query->where('id_category = ?', $this->getIdCategory());
        if ($this->getWhere())
            $query->where($this->getWhere());
        return $this->_db->fetchOne($query);
    }
}
?>
