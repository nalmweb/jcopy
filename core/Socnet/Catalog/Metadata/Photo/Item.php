<?php
class Socnet_Catalog_Metadata_Photo_Item extends Socnet_Data_Entity
{
    private $id;
    private $idTypeMetadata;
    private $typeMetadata;
    private $Data;
    private $fileName;
    
    public function __construct ($id = null)
    {
        parent::__construct('catalog__metadata', array('id' => 'id', 
        												'id_type_metadata' => 'idTypeMetadata',
                                                        /*'data' => 'data',*/
                                                        'file_name' => 'fileName'));
        
        if ( null !== $id) {
           $this->loadByPk($id);
        }
    }
    
    public function getDataPath(  ) {
        
        $path = BASE_URL. '/images/catalog/';
        $path .= $this->getTypeMetadata()->getPath();
        $path .= "/". $this->getFileName();
        
        return $path;
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
    public function getIdTypeMetadata ()
    {
        return $this->idTypeMetadata;
    }
    /**
     * @param unknown_type $name
     */
    public function setIdTypeMetadata ($idTypeMetadata)
    {
        $this->idTypeMetadata = $idTypeMetadata;
        return $this;
    }
    
    /**
     * @return unknown
     */
    public function getData ()
    {
        return $this->Data;
    }
    /**
     * @param unknown_type $name
     */
    public function setData ($data)
    {
        $this->Data = $data;
        return $this;
    }
    /**
     * @return unknown
     */
    public function getFileName ()
    {
        return $this->fileName;
    }
    /**
     * @param unknown_type $fileName
     */
    public function setFileName ($fileName)
    {
        $this->fileName = $fileName;
        return $this;
    }
    /**
     * @return unknown
     */
    public function getTypeMetadata ()
    {
        if ( null == $this->typeMetadata ) {
            $this->setTypeMetadata();
        }
        return $this->typeMetadata;
    }
    /**
     * @param unknown_type $typeMetadata
     */
    public function setTypeMetadata ()
    {
        if ( null !== $this->idTypeMetadata ) {
            $this->typeMetadata = new Socnet_Catalog_TypeMetadata_Item( $this->idTypeMetadata ); 
        }
    }        

}
?>
