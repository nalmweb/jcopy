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
class Socnet_Location_Timezone extends Socnet_Data_Entity
{
    public $id;
    public $name;
    public $tz_name;
    public $zone;

    /**
     * Constructor.
     *
     */
	public function __construct()
	{
	    $this->_db = Zend::registry("DB");
	}

	/**
	 * Get time zone data by name
	 *
	 * @param string $name
 	 * @return array
	 * @todo in PDO (AND)
	 */
	public function getTimeZoneByName($name)
	{
        $select = $this->_db->select()
                       ->from('mysql.time_zone_name AS tn', '*')
                       ->joinLeft('mysql.time_zone_transition AS tt2','tt2.Time_zone_id = tn.Time_zone_id')
                       ->joinLeft('mysql.time_zone_transition_type AS tt', 'tt.Time_zone_id = tn.Time_zone_id AND tt.Transition_type_id = tt2.Transition_type_id')
                       ->where('tn.Name = ?', $name)
                       ->where('tt2.Transition_time <= UNIX_TIMESTAMP(NOW())')
                       ->order('tt2.Transition_time DESC')
                	   ->limit(1);
        $result = $this->_db->fetchRow($select);
        return $result;
	}

	/**
	 * Get specific socnet timezones
	 *
	 * @return array
	 */
    public function getsocnetTimezonesAssoc()
    {
		$sql = $this->_db->select()->from('location__timezones', array('id', 'tz_name', 'name'));
		$timezones = $this->_db->fetchAll($sql);
		return $timezones;
    }

    /**
     * Get specific socnet timezones names (for forms)
     *
     * @return array 
     */
    public function getsocnetTimezonesNamesAssoc()
    {
        $timezones = $this->getsocnetTimezonesAssoc();
        $ret = array();
        foreach ($timezones as $k => &$v)
        {
            $time_zone = $this->getTimeZoneByName($v['tz_name']);
            $minutes = ($time_zone['offset'] % 3600) / 60;
            $hour = (int)(($time_zone['offset'] / 3600));
            if ($hour >= 0)
                $hour = '+'.$hour;
            if ($minutes == 0)
                $time = $hour;
            else
                $time = $hour.':'.abs($minutes);
            $ret[$v['id']] = trim($v['name']." (".$time_zone['abbreviation'].") = GMT ".$time);
        }
        return $ret;
    }

}

