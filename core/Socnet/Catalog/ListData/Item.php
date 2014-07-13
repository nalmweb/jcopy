<?php

class Socnet_Catalog_ListData_Item extends Socnet_Data_Entity
{
    private $id;
    private $name;
    private $idProperty;
    
    function __construct( $id = null ) 
    {
        parent::__construct('catalog__data_list_property', array('id' => 'id', 
                                                             'name' => 'name',
                                                             'id_property' => 'idProperty',
                                                              )
                            );

        if ( null !== $id) {
           $this->loadByPk($id);
        } 
    }
    /**
     * @return unknown
     */
    public function getId ()
    {
        return $this->id;
    }
    /**
     * @param unknown_type $id
     */
    public function setId ($id)
    {
        $this->id = $id;
        return $this;
    }
    /**
     * @return unknown
     */
    public function getIdProperty ()
    {
        return $this->idProperty;
    }
    /**
     * @param unknown_type $idProperty
     */
    public function setIdProperty ($idProperty)
    {
        $this->idProperty = $idProperty;
        return $this;
    }
    /**
     * @return unknown
     */
    public function getName ()
    {
        return $this->name;
    }
    /**
     * @param unknown_type $name
     */
    public function setName ($name)
    {
        $this->name = $name;
        return $this;
    }

    /*
     * FIXME Переделать!!!
     */
    public function getData() {
        $query = $this->_db->select();
        $query->from('catalog__data_list_property', array('id', 'name'));
        $query->where('id_property = ?', $this->getIdProperty() );
        //$query->__toString();
        return $this->_db->fetchPairs( $query );
    }

    public function getValues( $propertyId = null ) {
        if ( null !== $propertyId ) {
            $list = new Socnet_Catalog_ListData_List($propertyId);
            $list->returnAsAssoc();
            return $list->getList();
        }
        return false;
    }
}
?>
