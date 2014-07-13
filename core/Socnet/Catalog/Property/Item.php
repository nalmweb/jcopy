<?php
class Socnet_Catalog_Property_Item extends Socnet_Data_Entity
{
    private $id;
    private $name;
    private $idUnitDimension;
    private $idTypeProperty;
    private $shortView;
    private $listView;
    private $fullView;
    private $bboardView;
    private $idTypeAuto;
    private $description;
    
    private $typeProperty;
    private $unitDimension;
    
    public function __construct ($id = null)
    {
        parent::__construct('catalog__property', array('id' => 'id', 
        											   'name' => 'name',
                                                       'id_unit_dimension' => 'idUnitDimension',
                                                       'id_type_property' => 'idTypeProperty',
                                                       'short_view'    => "shortView",
                                                       'list_view'     => "listView",
                                                       'full_view'     => "fullView",
                                                       'bboard_view'   => "bboardView",
                                                       'id_type_auto'  => 'idTypeAuto',
                                                       'description'   => 'description'
                                                       ));
        
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
    public function getBboardView ()
    {
        return $this->bboardView;
    }
    /**
     * @param unknown_type $bboardView
     */
    public function setBboardView ($bboardView)
    {
        $this->bboardView = $bboardView;
        return $this;
    }
    /**
     * @return unknown
     */
    public function getFullView ()
    {
        return $this->fullView;
    }
    /**
     * @param unknown_type $fullView
     */
    public function setFullView ($fullView)
    {
        $this->fullView = $fullView;
        return $this;
    }
    /**
     * @return unknown
     */
    public function getListView ()
    {
        return $this->listView;
    }
    /**
     * @param unknown_type $listView
     */
    public function setListView ($listView)
    {
        $this->listView = $listView;
        return $this;
    }
    /**
     * @return unknown
     */
    public function getShortView ()
    {
        return $this->shortView;
    }
    /**
     * @param unknown_type $shortView
     */
    public function setShortView ($shortView)
    {
        $this->shortView = $shortView;
        return $this;
    }
	/**
	 * @return unknown
	 */
	public function getIdTypeProperty () {
		return $this->idTypeProperty ;
	}
	
	/**
	 * @param unknown_type $idTypeProperty
	 */
	public function setIdTypeProperty ( $idTypeProperty ) {
		$this->idTypeProperty = $idTypeProperty ;
		return $this;
	}
	
	/**
	 * @return unknown
	 */
	public function getIdUnitDimension () {
		return $this->idUnitDimension ;
	}

	public function setIdUnitDimension ( $idUnitDimension ) {
		$this->idUnitDimension = $idUnitDimension ;
		return $this;
	}	
	
	/**
	 * @param unknown_type $typeProperty
	 */
	public function setTypeProperty (  ) {
		if ( null !== $this->idTypeProperty ) {
	        $this->typeProperty = new Socnet_Catalog_TypeProperty_Item( $this->idTypeProperty ) ;
		}
	}
	
	public function getTypeProperty ( ) 
	{
	    if ( null == $this->typeProperty ) {
	        $this->setTypeProperty();
	    }
	    return $this->typeProperty;
	}
	
	/**
	 * @return unknown
	 */
	public function getUnitDimension () 
	{
	    if ( null == $this->unitDimension ) {
	        $this->setUnitDimension( );
	    }
	    
		return $this->unitDimension ;
	}
	
	/**
	 * @param unknown_type $idUnitDemension
	 */
	public function setUnitDimension ( ) 
	{
	    if ( null !== $this->idUnitDimension ) {
		    $this->unitDimension = new Socnet_Catalog_UnitDimension_Item( $this->idUnitDimension ) ;
	    }
		return $this;
	}
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
    /**
     * @return unknown
     */
    public function getDescription ()
    {
        return $this->description;
    }
    /**
     * @param unknown_type $description
     */
    public function setDescription ($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getListData() 
    {
        $list = new Socnet_Catalog_ListData_List($this->getId());
        $list->returnAsAssoc();
        return $list->getList();
    }
    
}
?>
