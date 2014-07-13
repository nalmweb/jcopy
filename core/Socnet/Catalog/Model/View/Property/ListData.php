<?php

class Socnet_Catalog_Model_Property_ListData extends Socnet_Data_Entity
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

    
}
?>
