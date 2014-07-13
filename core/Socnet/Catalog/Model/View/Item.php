<?php

class Socnet_Catalog_Model_View_Item extends Socnet_Data_Entity 
{
    private $id;
    private $idModel;
    private $idTrademark;
    private $idCategory;
    private $idPhoto;
    
    private $name;
    private $year;
    
    private $Model;
    private $Trademark;
    private $Category;
    private $Properties;
    private $Photo;
    private $Photos;
    private $RelatedUsers;
    
    private $viewMode;
    
    function __construct( $key = null, $value = null , $table = 'view__catalog_model_god')
    {
      parent::__construct($table, array('id' => 'id',
							   'id_model' => 'idModel',
							   'id_trademark' => 'idTrademark',
							   'id_category' => 'idCategory',
							   'name' => 'name',
							   'god' => 'year',
							   'id_photo' => 'idPhoto'
							   )
                            );
        
        if ( null !== $key) {
           $this->pkColName = $key;
           $this->loadByPk($value);
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
	public function getIdModel () {
		return $this->idModel ;
	}
	
	/**
	 * @param unknown_type $idModel
	 */
	public function setIdModel ( $idModel ) {
		$this->idModel = $idModel ;
		return $this;
	}
	
	/**
	 * @return unknown
	 */
	public function getModel () {
	    if ( null == $this->Model ) {
            $this->setModel();
        }
	    return $this->Model ;
	}
	
	/**
	 * @param unknown_type $model
	 */
	public function setModel ( ) {
	     if ( null !== $this->idModel ) {
            $this->Model = new Socnet_Catalog_Model_Item( $this-> idModel );
        }
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
    public function getTrademark ()
    {
        if ( null == $this->Trademark ) {
            $this->setTrademark();
        }
        return $this->trademark;
    }
    /**
     * @param unknown_type $Trademark
     */
    public function setTrademark ( )
    {
        if ( null !== $this->idTrademark ) {
            $this->trademark = new Socnet_Catalog_Trademark_Item( $this-> idTrademark );
        }
    }
    
    /**
     * @return unknown
     */
    public function getIdCategory ()
    {
        return $this->idCategory;
    }
    public function setIdCategory ($idCategory)
    {
        $this->idCategory = $idCategory;
        return $this;
    }
	
    /**
     * @return unknown
     */
    public function getCategory ()
    {
        if ( null == $this->Category ) {
            $this->setCategory();
        }
        return $this->Category;
    }
    /**
     * @param unknown_type $Trademark
     */
    public function setCategory ( )
    {
        if ( null !== $this->idCategory ) {
            $this->Category = new Socnet_Catalog_Category_Item( $this-> idCategory );
        }
    }
    
	/**
	 * @return unknown
	 */
	public function getName () {
		return $this->name ;
	}
	
	/**
	 * @param unknown_type $name
	 */
	public function setName ( $name ) {
		$this->name = $name ;
		return $this;
	}
	
	/**
	 * @return unknown
	 */
	public function getYear () {
		return $this->year ;
	}
	
	/**
	 * @param unknown_type $year
	 */
	public function setYear ( $year ) {
		$this->year = $year ;
		return $this;
	}
    /**
     * @return unknown
     */
    public function getProperties ()
    {
        if ( null == $this->Properties ) {
            $this->setProperties();
        }
        return $this->Properties;
    }
    /**
     * @param unknown_type $Properties
     */
    public function setProperties ( $Properties = null )
    {
        if ( null !== $Properties ) {
            $this->Properties = $Properties;
        } else
        if ( null !== $this->id ){
            $tmpList = new Socnet_Catalog_Model_Year_Property_List();
            
            $tmpList->returnAsAssoc( false )->setIdModelGod( $this->id );
            if ( null !== $this->getViewMode() ) {
                $func = 'set'.$this->getViewMode().'View';
                $tmpList->$func( true );
            }
            $this->Properties = $tmpList->getList();
        }
    }
    
    
    public function getPropertyValueById ( $idProperty ) {
    	
	    $tmpList = new Socnet_Catalog_Model_Year_Property_List();
	    
        $tmpList->returnAsAssoc( true ) -> setIdModelGod( $idProperty );
        
        $list = $tmpList->getList();
        
    	return $list;
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
    
    public function getPhoto() 
    {
        if ( null == $this->Photo ) {
            $this->setPhoto();
        }
        
        return $this->Photo;
    }
    
    public function setPhoto()
    {
        if ( null !== $this->idPhoto ) {
            $this->Photo = new Socnet_Catalog_Metadata_Item( $this->idPhoto );
        } else {
            if ( null !== $this->getPhotos() ) {
                $index = rand( 0, sizeof($this->Photos ) );
                $this->Photo = $this->Photos[$index];
            }
        }
    }
    /**
     * @return unknown
     */
    public function getIdPhoto ()
    {
        return $this->idPhoto;
    }
    /**
     * @param unknown_type $idPhoto
     */
    public function setIdPhoto ($idPhoto)
    {
        $this->idPhoto = $idPhoto;
        return $this;
    }


    public function getPhotos()
    {
        if ( null == $this->Photos ) {
            $this->setPhotos();
        }
/*        if ( sizeof( $this->Photos ) > 0 )
            return $this->Photos;*/
        
        return $this->Photos;
    }
    
    
    /**
     * Возвращает фотографии для текущей модели
     *
     * @return self
     * @todo Написать класс Socnet_Catalog_Metadata_Photo_Item() (_List()) 
     */
    public function setPhotos()
    {
        $items = null;
        $query = $this->_db->select();
        $query->from('catalog__model_property', 'value');
        $query->where('id_property = ?', 35);
        $query->where('id_model_god = ?', $this->id);
        //print $query->__toString();exit;
        $items = $this->_db->fetchCol( $query );
        
        if ( sizeof($items) > 0 ) {
            foreach ( $items as &$item ) $item = new Socnet_Catalog_Metadata_Item( $item );
        } else $items = null;
        
        $this->Photos = $items;
        return $this;
    }
    
    public function getRelatedUsers()
    {
        if ( null == $this->RelatedUsers ) {
            $this->setRelatedUsers();
        }
        
        return $this->RelatedUsers;
    }
    
    public function setRelatedUsers()
    {
        $mgList = new Socnet_Catalog_Model_Year_List();
        $mgList->setIdModel( $this->getIdModel() );
        $mgList->returnAsAssoc( true );
        
		$query = $this->_db->select();
        $query->from('user', 'id');
        $query->where('bike_id IN (?)', array_keys( $mgList->getList() ) );
        
        $items = $this->_db->fetchCol( $query );

        if ( sizeof($items) > 0 ) {
            if ( sizeof($items) > 5 ) {
              $items = array_flip( $items );
              $items = array_rand( $items, 5 );
            }
            foreach ( $items as &$item ) $item = new Socnet_User('id', $item );
        } else $items = null;
        
        $this->RelatedUsers = $items;
        return $this;
    }
}
?>
