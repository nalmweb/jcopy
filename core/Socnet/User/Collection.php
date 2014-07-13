<?php
/**
 * Socnet FRAMEWORK
 *
 * @package    Socnet_User
 * @copyright  Copyright (c) 2006
 *
 */
class Socnet_User_Collection
{
	/**
	 * Db connection object.
	 *
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
     * Возвращает количество пользователей
     * @param mixed $status - статус пользователя (string|array)
     * @return int
     */
    public function getUsersCount($status = 'active')
    {
        $select = $this->_db->select()
                      ->from('user', 'count(id) as count')
                      ->where('status IN (?)', $status);
        $users_count = $this->_db->fetchOne($select);
        return $users_count;
    }
	/**
	 * Возвращает список пользователей
	 * @param int $page - номер страницы
	 * @param int $size - количество элементов на страницу
	 * @param mixed $status - статус пользователя (string|array)
	 * @return mixed
	 */
    public function getUsersList($page = 1, $size = 0, $status = 'active')
    {
        $select = $this->_db->select()
                           ->from('user', 'id')
                           ->where('status IN (?)', $status)
                           ->order('login')
                           ->limitPage($page, ($size > 0 ? $size : MIN_NUMBER_LINE));
		  //dump($select->__toString());
    	$users = $this->_db->fetchCol($select);
    	foreach ($users as &$user) $user = new Socnet_User('id', $user);
    	return $users;

    }
    /**
     * Возвращяет список самых последних зарегестрированных пользователей
     * @package int $count - количество
     * @param unknown_type $count
     */
    public function getNewestUsers($count = 4)
    {
        $select = $this->_db->select();
        $select->from('user', 'id')
               ->where('status = ?', 'active')
               ->order('register_date DESC')
               ->limit($count);
    	$users = $this->_db->fetchCol($select);
    	foreach ($users as &$user) $user = new Socnet_User('id', $user);
    	return $users;
    }
    
    /**
     *   @param:  $bike_id - id_model 
     *   @return: a list of users who ride $bike_id from category_trademark id_type_auto=1  
     */
    public function getUsersByBike($bike_id,$count = 5 )
    {
    	// get a list if model_year for a model
    	$sql = $this->_db->select()->from("catalog__model_god",array("id"))->where("id_model =?",$bike_id);
    	$bikes = $this->_db->fetchAll($sql);
    	
    	$list_bikes = '';
    	foreach($bikes as $bike){
    		$list_bikes.=$bike['id'].",";
    	}
    	//$list_bikes='';
    	$list_bikes = substr($list_bikes,0,-1);
    	//echo $list_bikes;
    	$select = $this->_db->select()->from("user")->where("bike_id IN (?)",$list_bikes)
    	       			->order('register_date DESC')->limit($count);
    	/*$select = $this->_db->select();
        $select->from("user")
               ->where('bike_id = ?', $bike_id )
               ->order('register_date DESC'    )
               ->limit($count);*/
		//echo "sql = ".$select->__toString();               
    	$users = $this->_db->fetchCol($select);
    	foreach ($users as &$user) $user = new Socnet_User('id', $user);
    	return $users;
    }
}
?>
