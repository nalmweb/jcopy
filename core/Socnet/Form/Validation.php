<?
/**
 * 
 */
class Socnet_Form_Validation 
{
    
	static public function calc_period($date_start, $date_finish) 
	{
        $st = explode('-', date('d-m-Y', $date_start));
        $fin = explode('-', date('d-m-Y-H-i-s', $date_finish));
        $st[5]=0;
        $st[4]=0;
        $st[3]=0;
        if (($seconds = $fin[5] - $st[5]) < 0) {
                $fin[4]--;
                $minutes += 60;
        }

        if (($minutes = $fin[4] - $st[4]) < 0) {
                $fin[3]--;
                $minutes += 60;
        }

        if (($hours = $fin[3] - $st[3]) < 0) {
                $fin[0]--;
                $hours += 24;
        }

        if (($days = $fin[0] - $st[0]) < 0) {
                $fin[1]--;
                $days += date('t', mktime(1, 0, 0, $fin[1], $fin[0], $fin[2]));
        }

        if (($months = $fin[1] - $st[1]) < 0) {
                $fin[2]--;
                $months += 12;
        }

        $years = $fin[2] - $st[2];
        
        return $years;
	}    
	
    /**
     * callback function for email already existing validation
     *
     * @param string $email
     * @return boolean  true if error
     */
    static public function isUserEmailExist($email)
    {
        $_db = Zend::Registry('DB');
        $where = $_db->quoteInto('email=?', $email);
        $query = $_db->select()->from('socnet_users__accounts', 'id')->where($where);
        return $_db->fetchOne($query) ? true : false;
    }
    /**
     * callback function for login info validation
     *
     * @param array $hash
     * @return boolean  true if error
     */
    static public function isUserExist($hash)
    {
    	if ( !isset($hash['name']) || !isset($hash['pass']) ) return false;
        $db = Zend::registry("DB");
        $query = $db->select();
        $query->from("socnet_users__accounts", "id")
              ->where("login = ?", $hash['name'])
              ->where("pass = ?", md5($hash['pass']))
              ->where("status IN (?)", $hash['status']);
        $res = $db->fetchOne($query);
        return $res ? false : true;
    }
   /**
 	* callback function for age validation
 	*
 	* @param array $birthday
 	* @return boolean true if error
 	*/ 
    static public function isAgeValid($birthday)
    {
        $age = self::calc_period(strtotime($birthday['date_Day'].'-'.$birthday['date_Month'].'-'.$birthday['date_Year']),strtotime('now'));
/*    	$age = (strtotime('now') - strtotime($birthday['date_Year'].'-'.$birthday['date_Month'].'-'.$birthday['date_Day']));
    	$age /= 3600; // age in hours;
    	$age /= 24;   // age in days;
    	$age /= 365;  // age in years;*/
    	return ($age < 13);
	}    
	/**
 	* callback function for login already existing validation
 	*
 	* @param string $login
 	* @return boolean  true if error
 	*/
	static public function isLoginExist($login)
	{
	    $_db = Zend::Registry('DB');
    	$where = $_db->quoteInto('login=?', $login);
    	$sql = $_db->select()->from('socnet_users__accounts', 'id')->where($where);
    	return $_db->fetchOne($sql) ? true : false;
	}	    
	/**
 	* callback function for captcha verification code validation
 	*
 	* @param array $Values
 	* @return boolean  true if error
 	*/
	
	static public function isCaptchaCodeNotValid($Values)
	{
		global $CAPTCHA_CONFIG;
		if ($Values === '') return true;
		
		$captcha = new b2evo_captcha($CAPTCHA_CONFIG);		
		return ($captcha->validate_submit($Values['key'], $Values['userkey'])===0) ? true: false;		
	}
	
    /**
 	* callback function for login validation exclude user ids
 	*
 	* @param array $params (login and excludeIds)
 	* @return boolean  true if error
 	*/
    static public function isNewLoginExist($params)
	{
	    $_db = Zend::Registry('DB');
    	$where = $_db->quoteInto('login=?', $params['login']);
    	$sql = $_db->select()->from('socnet_users__accounts', 'id')->where($where);
    	if (isset($params['excludeIds'])) {    		
           $sql->where($_db->quoteInto('id NOT IN (?)', $params['excludeIds'])); 
    	}
    	return $_db->fetchOne($sql) ? true : false;		
	}

    /**
 	* callback function for email validation exclude user ids
 	*
 	* @param array $params (login and excludeIds)
 	* @return boolean  true if error
 	*/	
	
    static public function isNewUserEmailExist($params)
    {
        $_db = Zend::Registry('DB');
        $where = $_db->quoteInto('email=?', $params['email']);
        $query = $_db->select()->from('socnet_users__accounts', 'id')->where($where);
       	if (isset($params['excludeIds'])) {    		
           $query->where($_db->quoteInto('id NOT IN (?)', $params['excludeIds'])); 
    	}
        return $_db->fetchOne($query) ? true : false;
    }
    
    /**
 	* callback function for Group Name already exist validation exclude group ids
 	*
 	* @param array $params (login and excludeIds)
 	* @return boolean  true if error
 	*/	
    static public function isNewGroupExist($params)
    {
      	$_db = Zend::Registry('DB');

    	$where = $_db->quoteInto('name=?', $params['gname']);
    	$sql = $_db->select()->from('socnet_groups__items', 'id')->where($where);
       	if (isset($params['excludeIds'])) {    		
           $sql->where($_db->quoteInto('id NOT IN (?)', $params['excludeIds'])); 
    	}    	
    	return $_db->fetchOne($sql) ? true : false;	
	}
    /**
 	* callback function for Group Name already exist validation exclude group ids
 	*
 	* @param array $params (key, value, excludeIds)
 	* @return boolean  true if error
 	*/	
    static public function isGroupExist($params)
    {
        if ( empty($params['exclude']) ) $params['exclude'] = null;
        return Socnet_Group_Standard::isGroupExists($params['key'], $params['value'], $params['exclude']);
	}	
    /**
 	* callback function for validate join code
 	*
 	* @param array $params (group_id, join_code)
 	* @return boolean  true if error
 	*/	
    static public function isJoinCodeValid($params)
    {
        if (!isset($params['group_id']) || !isset($params['join_code'])) return true;
        $_db = Zend::Registry('DB');
        $query = $_db->select();
        $query->from('socnet_groups__items', 'id')
                ->where('id = ?', $params['group_id'])
                ->where('BINARY join_code = ?', $params['join_code']);
        $res = $_db->fetchCol($query);
        return !((bool) $res);
	}
	
}