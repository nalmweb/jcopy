<?php
/**
 * Socnet FRAMEWORK
 *
 * @package    Socnet_Location
 * @copyright  Copyright (c) 2006
 */

/**
 *
 *
 */
class Socnet_Location_City extends Socnet_Data_Entity
{
    public $id;
    public $countryId;
    public $name;
    public $status;
    private $Latitude = null;
    private $Longitude = null;

    private $Country;
    private $Metro;
    /**
     * Constructor.
     *
     */
	public function __construct($id = null)
	{
        parent::__construct('location__cities');

        $this->addField('id');
        $this->addField('country_id', 'countryId');
        $this->addField('name');
        $this->addField('status');
        $this->loadByPk($id);
	}
	/**
	 * Устанавливает Country для City
	 * @return void
	 */
    public function setCountry()
    {
        $this->Country = new Socnet_Location_Country($this->countryId);
        return $this;
    }
    /**
     * Возвращает Country для City
     * @return Socnet_Location_State
     */
    public function getCountry()
    {
        if ( $this->Country === null ) {
            $this->setCountry();
        }
        return $this->Country;
    }

	/**
	 * Устанавливает metro для City
	 * @return void
	 */
    public function setMetro()
    {
        $this->Metro = new Socnet_Location_Metro($this->id, 'city_id');
        return $this;
    }
    /**
     * Возвращает Country для City
     * @return Socnet_Location_State
     */
    public function getMetro()
    {
        if ( null === $this->Metro ) {
            $this->setMetro();
        }
        return $this->Metro;
    }
    	/**
	 * Получить список метро для текущего города
	 * @return array of Socnet_Location_City
	 */
	public function getMetroesList()
	{
		$sql = $this->_db->select()
		                 ->from('location__metroes', 'id')
		                 //->where('city_id=?', $this->id)
		                 ;
		$metroes = $this->_db->fetchCol($sql);
		foreach($metroes as &$metro) $metro = new Socnet_Location_Metro($metro);
		return $metroes;
	}
	/**
	 * Получить список метро города для <select>
	 * @return array - возвращает массив пар значений 'id', 'name'
	 */
	public function getMetroesListAssoc()
	{
		$sql = $this->_db->select()
		            ->from('location__metroes', array('id', 'name'))
		            ->order('name');
		if ($this->id) $sql->where('city_id=?', $this->id);
		            
		return $this->_db->fetchPairs($sql);
	}

    public static function isCityExists($inArray = array())
    {
        $db = Zend::registry("DB");
        $select = $db->select();
        $select->from('location__cities','count(id) as count')
               ->where('country_id = ?', $inArray['country'])
               ->where('name = ?', $inArray['name']);
        $res = $db->fetchOne($select);
        return (boolean) $res;
    }

    public function save()
    {
        parent::save();
    }

	/**
	 * set Latitude Longitude
	 *
	 */
	public function setLatitudeLongitude()
	{
        $sql = $this->_db->select()
                         ->from('location__cities AS lc', array('longitude', 'latitude'))
                         ->where('lc.id = ?', $this->id);
        $coord = $this->_db->fetchRow($sql);
	    $this->Latitude    = empty($coord['latitude']) ? 55.73948 : $coord['latitude'];
	    $this->Longitude   = empty($coord['longitude']) ? 37.62817 : $coord['longitude'];
	}
	/**
	 * get Latitude
     *
	 */
	public function getLatitude()
	{
        if ( $this->Latitude === null ) {
            $this->setLatitudeLongitude();
        }
        return $this->Latitude;
	}
	/**
	 * get Longitude
	 * 
	 */
	public function getLongitude()
	{
        if ( $this->Longitude === null ) {
            $this->setLatitudeLongitude();
        }
        return $this->Longitude;
	}
	public function getName(){
    	return $this->name;
    }
}