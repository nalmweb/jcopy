<?
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
class Socnet_Location
{
	/**
	 * Db connection object.
	 * @var object
	 */
    public $_db;

    /**
     * Constructor.
     *
     */
	public function __construct()
	{
	    $this->_db = Zend::registry("DB");
	}

	/**
	 * get countries list
	 * @return array of objets
	 */
	public static function getCountriesList($page = null)
	{
    $db = Zend::registry("DB");
    $qeary = $db->select();
    $qeary->from('location__countries', 'id');
    if($page)
      $qeary->limitPage($page);
		$countries = $db->fetchCol($qeary);
    foreach ($countries as &$country) $country = new Socnet_Location_Country($country);
		return $countries;
	}

  /**
   * get countries count
   * @return number
   */
  public static function getCountriesCount()
  {
    $db = Zend::registry("DB");
    $qeary = $db->select();
    $qeary->from('location__countries', 'count(id)');
    return $db->fetchOne($qeary);
  }

  /**
   * get city count
   * @return number
   */
  public static function getCityCount()
  {
    $db = Zend::registry("DB");
    $qeary = $db->select();
    $qeary->from('location__cities', 'count(id)');
    return $db->fetchOne($qeary);
  }

	/**
	 * get countries list
	 * @return array
	 */
	public static function getCountriesListAssoc($page = null)
	{
	  $db = Zend::registry("DB");
    $qeary = $db->select();
		$qeary->from('location__countries', array('id', 'name'));

    if($page)
      $qeary->limitPage($page);

		$countries = $db->fetchPairs($qeary);
		return $countries;
	}

  /**
   * get city list
   * @return array
   */
  public static function getCityListAssoc($page = null)
  {
    $db = Zend::registry("DB");
    $qeary = $db->select();
    $qeary->from('location__cities', array('id','name'));
    $qeary->joinLeft('location__countries','location__countries.id = location__cities.country_id',array('countriName'=>'name'));
    $qeary->order('name');
    if($page)
      $qeary->limitPage($page);

    $city = $db->fetchAll($qeary);
    return $city;
  }
}
?>