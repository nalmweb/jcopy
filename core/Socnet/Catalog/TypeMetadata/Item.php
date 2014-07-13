<?php
class Socnet_Catalog_TypeMetadata_Item extends Socnet_Data_Entity
{
    private $id;
    private $name;
    private $path;

    public function __construct ($id = null)
    {
        parent::__construct('catalog__type_metadata', array('id' => 'id', 
        													'name' => 'name',
                                                            'path' => 'path'));
        
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
    /**
     * @return unknown
     */
    public function getPath ()
    {
        return $this->path;
    }
    /**
     * @param unknown_type $path
     */
    public function setPath ($path)
    {
        $this->path = $path;
        return $this;
    }
}
?>
