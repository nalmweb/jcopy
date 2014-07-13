<?php
class Socnet_Catalog_SemanticTypeData_Item extends Socnet_Data_Entity
{
    private $id;
    private $name;
    
    public function __construct ($id = null)
    {
        parent::__construct('catalog__semantic_type_data', array('id' => 'id', 'name' => 'name'));
        
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
