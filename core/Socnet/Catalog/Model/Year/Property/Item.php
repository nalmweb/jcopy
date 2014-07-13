<?php

class Socnet_Catalog_Model_Year_Property_Item extends Socnet_Data_Entity 
{
	private $id;
	private $idProperty;
	private $idModelGod;
	private $value;
	private $valuesList;
	private $valuesListData;
	private $flagDisc;
	private $property;
	
    function __construct( $id = null ) 
    {
        parent::__construct('catalog__model_property', array('id' => 'id', 
        													 'id_property' => 'idProperty',
                                                             'id_model_god' => 'idModelGod',
                                                             'value' => 'value',
                                                             'value_list' => 'valuesList',
  															 'flag_disc' => 'flagDisc',
                                                              )
                            );

		if ( null !== $id) {
           $this->loadByPk($id);
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
   
   /**
     * @param unknown_type $valuesList
     */
    public function setValuesList($valuesList) {
        $this->valuesList = $valuesList;
        return $this;
    }
	
	public function getValuesListData() {
	    if ( null == $this->valuesListData ) {
	        $this->setValuesListData();
	    }
	    return $this->valuesListData;
	}

	
    public function setValuesListData() {
        if ( null !== $this->valuesList ) {
            $this->valuesListData = new Socnet_Catalog_Model_Property_ListData( $this->valuesList );
        } elseif( $this->getProperty()->getIdTypeProperty() == 3 ) { 
            $this->valuesListData = new Socnet_Catalog_ListData_Item( );
            $this->valuesListData->setIdProperty( $this->getIdProperty() );
        }
        return $this;
    }
	
    /**
     * @return unknown
     */
    public function getProperty ()
    {
        if ( null == $this->property ) {
            $this->setProperty();
        }
        return $this->property;
    }
    /**
     * @param unknown_type $Properties
     */
    public function setProperty ( )
    {
        if ( null !== $this->idProperty ){
            $this->property = new Socnet_Catalog_Property_Item( $this->getIdProperty() );
        }
    }
}
?>
