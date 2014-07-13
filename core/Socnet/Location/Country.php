<?php
/**
 * Socnet FRAMEWORK
 *
 * @package    Socnet_Location
 * @copyright  Copyright (c) 2007
 */

/**
 *
 *
 */
class Socnet_Location_Country extends Socnet_Data_Entity
{
    public $id;
    public $countryId;
    public $name;
    public $code;
    public $status;

    private $Country;
    /**
     * Constructor.
     *
     */
	public function __construct($id = null)
	{
        parent::__construct('location__countries');

        $this->addField('id');
        $this->addField('name');
        $this->addField('shortname');
        $this->loadByPk($id);
	}

     public static function isCountryExists($name)
    {
        $db = Zend::registry("DB");
        $select = $db->select();
        $select->from('location__countries','count(id) as count')
               ->where('name = ?', $name);
        $res = $db->fetchOne($select);
        return (boolean) $res;
    }

	/**
	 * Получить список городов
	 * @return array of Socnet_Location_City
	 */
	public function getCitiesList()
	{
		$sql = $this->_db->select()
		                 ->from('location__cities', 'id')
		                 ->where('country_id=?', $this->id);
		$cities = $this->_db->fetchCol($sql);
		foreach($cities as &$city) $sity = new Socnet_Location_City($city);
		return $cities;
	}

	/**
	 * Получить список городов
	 * @return array - возвращает массив пар значений 'id', 'name'
	 */
	public function getCitiesListAssoc()
	{
		$sql = $this->_db->select()
		            ->from('location__cities', array('id', 'name'))
		            ->order('name');
        if ($this->id) $sql->where('country_id=?', $this->id);
		
		$cities = $this->_db->fetchPairs($sql);
		return $cities;
	}
    public function save()
    {
        parent::save();
    }
    
    public function getName(){
    	return $this->name;
    }
}