<?php
class Socnet_Catalog_Metadata_Item extends Socnet_Data_Entity
{
    private $id;
    private $idTypeMetadata;
    private $typeMetadata;
    private $Data;
    private $fileName;
    private $originalFileName;
    
    public function __construct ($id = null)
    {
        parent::__construct('catalog__metadata', array('id' => 'id', 
        												'id_type_metadata' => 'idTypeMetadata',
                                                        /*'data' => 'data',*/
                                                        'file_name' => 'fileName',
                                                        'originalFileName' => 'originalFileName'));
        
        if ( null !== $id) {
           $this->loadByPk($id);
        }
    }
    
    public function getDataPath(  ) 
    {
        if ( $this->id ) {
            $path = BASE_URL. '/images/catalog/';
            $path .= $this->getTypeMetadata()->getPath();
            $path .= "/". $this->getFileName();
            
            return $path;
        }
    }
    
    public function getThumbnailPath(  ) 
    {
        return $this->getDataPath()."_thumbnail.jpg";;
    }
    
    public function getOriginalPath(  ) 
    {
        return $this->getDataPath()."_big.jpg";
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
	/**
	 * @return unknown
	 */
	public function getOriginalFileName() {
		return $this->originalFileName;
	}
	
	/**
	 * @param unknown_type $originalFileName
	 */
	public function setOriginalFileName($originalFileName) {
		$this->originalFileName = $originalFileName;
	}
        
    public static function getIdByName( $name = null )
    {
        if ( null !== $name ) {
            $db = Zend_Registry::get('DB');
            $query = $db->select();
            $query->from('catalog__metadata', 'id');
            $query->where('file_name = ?', $name);
            return $db->fetchOne( $query );
        } 
        return false;
    }
    
    public static function deleteByIds( $Ids = null ) 
    {
        if ( null !== $Ids ) {
            $db = Zend_Registry::get('DB');


            foreach ($Ids as $id ) {
                $where = array( 
                    $db->quoteInto('id_property = ?', 35),
                    $db->quoteInto('value = ?', self::getIdByName($id))
                    );
                   
                $db->delete('catalog__model_property', $where);
            }
            
            $where = $db->quoteInto('file_name IN (?)', $Ids);
            $rows_affected = $db->delete('catalog__metadata', $where);
            
            if ( $rows_affected > 0 ) {
                foreach ( $Ids as $file ) {
                    @unlink(CATALOG_PHOTOS. $file. '_thumbnail.jpg');
                    @unlink(CATALOG_PHOTOS. $file. '_big.jpg');
                }
            }
            
            return $rows_affected;
        } 
        return false;
    }
}
?>
