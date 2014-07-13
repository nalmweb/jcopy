<?php
class Socnet_Catalog_Trademark_List extends Socnet_Abstract_List 
{
    private $idTypeAuto;
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
            $query->from('catalog__trademark', $fields);  
        } else {
            $query->from('catalog__trademark', 'id');
        }
        
        if ( null !== $this->getIdTypeAuto()) {
            $query->where('id_type_auto = ?', $this->getIdTypeAuto());
        }
        
        if ( $this->getWhere() ) $query->where( $this->getWhere() );
        
        if ( $this->getCurrentPage() !== null && $this->getListSize() !== null ) {
            $query->limitPage($this->getCurrentPage(), $this->getListSize());
        }
        if ( $this->getOrder() !== null ) {
            $query->order($this->getOrder());
        }
        //print $query->__toString();
        $items = array();
        if ( $this->isAsAssoc() ) {
            $items = $this->_db->fetchPairs($query);
        } else {
            $items = $this->_db->fetchCol($query);
            foreach ( $items as &$item ) $item = new Socnet_Catalog_Trademark_Item($item);
        }
        return $items;       
    }
    
    /**
	 * Получить список марок для <select>
	 * @return array - возвращает массив пар значений 'id', 'name'
	 */
	public function getListAssoc($id='')
	{
		$sql='';
		if(!empty($id))
		{
		   $sql = $this->_db->select()
		            ->from('catalog__trademark', array('id', 'name'))
		            ->where('id_type_auto=?',$id)
		            ->order('name');
		}
		else
		{
			$sql = $this->_db->select()
		            ->from('catalog__trademark', array('id', 'name'))
		            ->order('name');            
		}           
		return $this->_db->fetchPairs($sql);
	}
    
    
    public function getCount()
    {
        $query = $this->_db->select();
        $query->from('catalog__trademark', 'COUNT(*)');
        if ( null !== $this->getIdTypeAuto()) $query->where('id_type_auto = ?', $this->getIdTypeAuto());
        if ( $this->getWhere() ) $query->where($this->getWhere());
        return $this->_db->fetchOne($query);
    }
}
?>
