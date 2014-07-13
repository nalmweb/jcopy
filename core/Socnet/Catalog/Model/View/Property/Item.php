<?php

class Socnet_Catalog_Model_View_Property_Item extends Socnet_Data_Entity 
{
	private $id;
	private $idProperty;
	private $idModelGod;
	private $value;
	private $valuesList;
	private $valuesListData;
	private $shortView;
    private $listView;
    private $fullView;
    private $bboardView;

	private $property;
	
    function __construct( $key = null, $value = null ) 
    {
        parent::__construct('view__catalog_model_property', array('id' => 'id', 
        													 'id_property' => 'idProperty',
                                                             'id_model_god' => 'idModelGod',
                                                             'value' => 'value',
                                                             'value_list' => 'valuesList',
                                                             'short_view' => 'shortView',
                                                             'list_view'    => 'listView',
                                                             'full_view'    => 'fullView',
                                                             'bboard_view'  => 'bboardView'
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
	public function getFlagDisc() {
		return $this->flagDisc;
	}
	
	/**
	 * @param unknown_type $flagDisc
	 */
	public function setFlagDisc($flagDisc) {
		$this->flagDisc = $flagDisc;
		return $this;
	}
	
	/**
	 * @return unknown
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @param unknown_type $id
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	/**
	 * @return unknown
	 */
	public function getIdModelGod() {
		return $this->idModelGod;
	}
	
	/**
	 * @param unknown_type $idModelGod
	 */
	public function setIdModelGod($idModelGod) {
		$this->idModelGod = $idModelGod;
		return $this;
	}
	
	/**
	 * @return unknown
	 */
	public function getIdProperty() {
		return $this->idProperty;
	}
	
	/**
	 * @param unknown_type $idProperty
	 */
	public function setIdProperty($idProperty) {
		$this->idProperty = $idProperty;
		return $this;
	}
	
	/**
	 * @return unknown
	 */
	public function getValue() {
		return $this->value;
	}
	
	/**
	 * @param unknown_type $value
	 */
	public function setValue($value) {
		$this->value = $value;
		return $this;
	}
	
	/**
	 * @return unknown
	 */
	public function getValuesList() {
		return $this->valuesList;
	}
	
	public function getValuesListData() {
	    if ( null == $this->valuesListData ) {
	        $this->setValuesListData();
	    }
	    return $this->valuesListData;
	}
	
    public function setValuesListData() {
        if ( null !== $this->getValuesList() ) {
            $this->valuesListData = new Socnet_Catalog_Model_Property_ListData( $this->getValuesList() );
        } else $this->valuesListData = null;
    }
	
	/**
	 * @param unknown_type $valuesList
	 */
	public function setValuesList($valuesList) {
		$this->valuesList = $valuesList;
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
    public function setBboardView ($bboardView = true)
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
    public function setFullView ($fullView = true)
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
    public function setListView ($listView = true)
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
    public function setShortView ($shortView = true)
    {
        $this->shortView = $shortView;
        return $this;
    }
    
	
	
    /**
     * @return unknown
     */
    public function getProperty ()
    {
        if ( null == $this->Property ) {
            $this->setProperty();
        }
        return $this->Property;
    }
    /**
     * @param unknown_type $Properties
     */
    public function setProperty ( )
    {
        if ( null !== $this->idProperty ){
            $this->Property = new Socnet_Catalog_Property_Item( $this->getIdProperty() );
        }
    }
}
?>
