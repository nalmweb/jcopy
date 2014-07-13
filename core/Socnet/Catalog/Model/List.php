<?php
class Socnet_Catalog_Model_List extends Socnet_Abstract_List 
{
    private $idTrademark;
    private $idCategory;
    private $idPrimaryImage;
    private $viewMode;
    private $display;    
   	
    public function __construct( $trademark = null ) {
        $this->_db = Zend::registry("DB");
        if ( null !== $trademark ) {
            $this->setIdTrademark( $trademark ); 
        }
    }
	/**
     * @return unknown
     */
    public function getIdCategory ()
    {
        return $this->idCategory;
    }
    /**
     * @param unknown_type $idCategory
     */
    public function setIdCategory ($idCategory)
    {
        $this->idCategory = $idCategory;
        return $this;
    }
    /**
     * @return unknown
     */
    public function getIdPrimaryImage ()
    {
        return $this->idPrimaryImage;
    }
    /**
     * @param unknown_type $idPrimaryImage
     */
    public function setIdPrimaryImage ($idPrimaryImage)
    {
        $this->idPrimaryImage = $idPrimaryImage;
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
    
    public function getList()
    {
        $query = $this->_db->select();
        if ( $this->isAsAssoc() ) {
            $fields = array();
            $fields[] = ( $this->getAssocKey() === null ) ? 'id' : $this->getAssocKey();
            $fields[] = ( $this->getAssocValue() === null ) ? 'name' : $this->getAssocValue();
            $query->from('catalog__model', $fields);  
        } else {
            $query->from('catalog__model', 'id');
        }
        if ( $this->getWhere() ) $query->where( $this->getWhere() );

        if ( null !== $this->getIdCategory()) {
            $query->where('id_category = ?', $this->getIdCategory() );
        }
        
        if ( null !== $this->getIdTrademark()) {
            $query->where('id_trademark = ?', $this->getIdTrademark() );
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
            foreach ( $items as &$item ) $item = new Socnet_Catalog_Model_Item($item);
        }
        return $items;       
    }
    
     /**
	 * Получить список моделей для указанного производителя.<select>
	 * @param: int - id производителя  
	 * @return array - возвращает массив пар значений 'id', 'name'
	 */
	public function getListAssoc($id)
	{
		if(empty($id)) return 0;
		
		$sql = $this->_db->select()
		            ->from('catalog__model', array('id', 'name'))
		            ->where('id_trademark = ?',$id)
		            ->order('name');
		return $this->_db->fetchPairs($sql);
	}
    
    
    public function getCount()
    {
        $query = $this->_db->select();
        $query->from('catalog__model', 'COUNT(*)');
        if ( null !== $this->getIdCategory()) $query->where('id_category = ?', $this->getIdCategory() );
        if ( null !== $this->getIdTrademark()) $query->where('id_category = ?', $this->getIdTrademark() );
        if ( $this->getWhere() ) $query->where($this->getWhere());
        return $this->_db->fetchOne($query);
    }
}
?>
