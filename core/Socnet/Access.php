<?php
/**
 * Socnet FRAMEWORK
 *
 * @package    Socnet_Access
 * @copyright  Copyright (c) 2007
 */

/**
 *
 *
 */
class Socnet_Access
{

    /**
     * Constructor
     * 
     */
    public function __construct()
    {
    }





    /**
     * Returns action ID by primary entity name, secondary entity name and action name
     *
     * @param string $pri_entity_name
     * @param string $sec_entity_name
     * @param string $action_name
     * @return boolean
     */
    public static function getActionIdByEEA($pri_entity_name, $sec_entity_name, $action_name)
    {
        $db = Zend::registry("DB");

        $select = $db->select()
        ->from('entity__entity_actions AS A', 'A.id')
        ->joinLeft('entity__types AS B','B.id = A.pri_entity_type_id')
        ->joinLeft('entity__types AS C','C.id = A.sec_entity_type_id')
        ->joinLeft('entity__actions AS D','D.id = A.entity_action_id')
        ->where('B.name = ?', $pri_entity_name)
        ->where('C.name = ?', $sec_entity_name)
        ->where('D.entity_action = ?', $action_name);

        $result = $db->fetchOne($select);

        return empty($result)?0:$result;
    }





    /**
     * Returns role ID by role name
     *
     * @param string $role_name
     * @return unknown
     */
    public static function getRoleIdByName($role_name)
    {
        $db = Zend::registry("DB");

        $select = $db->select()
        ->from('user__roles', 'id')
        ->where('role = ?', $role_name);

        $result = $db->fetchOne($select);

        return empty($result)?false:$result;
    }





    /**
     * Check access in primary & secondary tables
     *
     * @param integer $user_id
     * @param string $pri_entity_name
     * @param integer $entity_id
     * @param string $sec_entity_name
     * @param string $subaction
     * @return boolean
     */
    public static function isAccess($user_id = null, $entity_id = null, $pri_entity_name, $sec_entity_name, $action_name)
    {
        $db = Zend::registry("DB");

        $action_hash[] = Socnet_Access::getActionIdByEEA($pri_entity_name, $sec_entity_name, $action_name);
        $action_hash[] = Socnet_Access::getActionIdByEEA($pri_entity_name, $sec_entity_name, 'all');
        $action_hash[] = Socnet_Access::getActionIdByEEA($pri_entity_name, 'all', $action_name);
        $action_hash[] = Socnet_Access::getActionIdByEEA($pri_entity_name, 'all', 'all');
        $action_hash[] = Socnet_Access::getActionIdByEEA('all', $sec_entity_name, $action_name);
        $action_hash[] = Socnet_Access::getActionIdByEEA('all', $sec_entity_name, 'all');
        $action_hash[] = Socnet_Access::getActionIdByEEA('all', 'all', $action_name);
        $action_hash[] = Socnet_Access::getActionIdByEEA('all', 'all', 'all');
        $action_hash = array_values(array_unique($action_hash));

        //@todo OR @auhtor Komarovski
        $select = $db->select()
        ->from('view_permissions__list', 'id');
        if (!empty($user_id)){
            $select->where($db->quoteInto('user_id = ? ', $user_id));
        }
        else {
            $select->where('user_id IS NULL');
        }
        //$select->where($db->quoteInto('user_id = ? ', $user_id));
        //$select->where($db->quoteInto('(action_id = '.$action_id.' OR action_id = ?)', $action_all));
        $select->where($db->quoteInto('action_id IN (?)', $action_hash));
        $select->where($db->quoteInto('allow = ? ', 1));
        if ($entity_id !== null){
            //NULL=*
            //$select->where('entity_id = ?', $entity_id);
            $select->where($db->quoteInto('(entity_id = '.$entity_id.' OR entity_id IS NULL OR entity_id = ?)',0));
        }
        else {
            $select->where('entity_id IS NULL');
        }

        $result = $db->fetchAll($select);

        return (boolean) $result;

    }





    /**
     * Add user role (may be for some entity)
     *
     * @param integer $user_id
     * @param string $role_name
     * @param integer $entity_id
     * @return boolean
     */
    public static function addRole($user_id, $role_name, $entity_id = null)
    {
        $db = Zend::registry("DB");

        $role_id = Socnet_Access::getRoleIdByName($role_name);

        if ($role_id){

            $select = $db->select()
            ->from('user__roleaccess', 'id')
            ->where('user_id = ?', $user_id)
            ->where('role_id = ?', $role_id);

            if ($entity_id !== null) {
                $select->where('entity_id = ?', $entity_id);
            }
            else{
                $select->where('entity_id IS NULL');
            }

            $result = $db->fetchOne($select);

            if (empty($result))
            {
                $db->insert('user__roleaccess', array(
                'user_id'     => $user_id,
                'role_id'     => $role_id,
                'entity_id'   => $entity_id));
            }
            else
            {
                $db->update('user__roleaccess', array(
                'user_id'     => $user_id,
                'role_id'     => $role_id,
                'entity_id'   => $entity_id), $db->quoteInto('id = ?', $result));
            }
            return true;
        }
        return false;
    }





    /**
     * Remove user role
     *
     * @param integer $user_id
     * @param string $role_name
     * @param integer $entity_id
     * @return boolean
     */
    public static function removeRole($user_id, $role_name, $entity_id = null)
    {
        $db = Zend::registry("DB");

        $role_id = Socnet_Access::getRoleIdByName($role_name);

        if ($role_id){

            if ($entity_id !== null) {
                $where = 'entity_id = '.$entity_id;
            }
            else{
                $where = 'entity_id IS NULL';
            }
            $db->delete('user__roleaccess',
            $db->quoteInto('user_id = '.$user_id.' AND '.$where.' AND role_id = ?', $role_id));

            return true;
        }
        return false;
    }





    /**
     * Add user role (may be for some entity)
     *
     * @param string $role_name
     * @param integer $entity_id
     * @return array of object
     */
    public static function getUsersListByRole($role_name, $entity_id = null)
    {
        $db = Zend::registry("DB");

        $result=array();

        $role_id = Socnet_Access::getRoleIdByName($role_name);

        if ($role_id){

            $select = $db->select()
            ->from('user__roleaccess', 'user_id')
            ->where('role_id = ?', $role_id);
            if ($entity_id !== null) {
                $where = 'entity_id = '.$entity_id;
            }


            $result = $db->fetchCol($select);

            foreach ($result as &$item)
            {
                $item = new Socnet_User('id',$item);
            }
        }
        return $result;
    }





    /**
     * Returns true if role $role_name exists for user $user_id
     *
     * @param integer $user_id
     * @param string $role_name
     * @param integer $entity_id
     * @return boolean
     */
    /* public static function isRole($user_id, $role_name, $entity_id = null)
    {
    $db = Zend::registry("DB");

    $result=array();

    $role_id = Socnet_Access::getRoleIdByName($role_name);

    if ($role_id){

    $select = $db->select()
    ->from('user__roleaccess', 'user_id')
    ->where('user_id = ?', $user_id)
    ->where('role_id = ?', $role_id);
    if ($entity_id !== null) {
    $where = 'entity_id = '.$entity_id;
    }
    else{
    $where = 'entity_id IS NULL';
    }

    $result = $db->fetchOne($select);


    }
    return empty($result)?false:true;
    }
    */




    /**
     * Add access fields into additional table
     *
     * @param integer $user_id
     * @param integer $entity_type_id
     * @param integer $entity_id
     * @param string $pri_entity_name
     * @param string $sec_entity_name
     * @param string $action_name
     * @param int1 $allow
     * @return boolean
     */
    public static function addAccess($user_id, $entity_id = null, $pri_entity_name, $sec_entity_name, $action_name, $allow=0 )
    {
        $db = Zend::registry("DB");

        $action_id = Socnet_Access::getActionIdByEEA($pri_entity_name, $sec_entity_name, $action_name);

        if ($action_id){

            $select = $db->select()
            ->from('user__access', 'id')
            ->where('user_id = ?', $user_id)
            ->where('action_id = ?', $action_id);

            if ($entity_id !== null) {
                $select->where('entity_id = ?', $entity_id);
            }
            else{
                $select->where('entity_id IS NULL');
            }

            $result = $db->fetchOne($select);

            if (empty($result))
            {
                $db->insert('user__access', array(
                'user_id'        => $user_id,
                'entity_id'      => $entity_id,
                'action_id'      => $action_id,
                'allow'          => $allow));
            }
            else
            {
                $db->update('user__access', array(
                'user_id'        => $user_id,
                'entity_id'      => $entity_id,
                'action_id'      => $action_id,
                'allow'          => $allow), $db->quoteInto('id = ?', $result));
            }
            return true;
        }
        return false;
    }





    /**
     * Remove access records from additional table
     *
     * @param integer $user_id
     * @param integer $entity_type_id
     * @param integer $entity_id
     * @param string $pri_entity_name
     * @param string $sec_entity_name
     * @param string $action_name
     * @return boolean
     */
    public static function removeAccess($user_id, $entity_id = null, $pri_entity_name, $sec_entity_name, $action_name)
    {
        $db = Zend::registry("DB");

        $action_id = Socnet_Access::getActionIdByEEA($pri_entity_name, $sec_entity_name, $action_name);

        if ($action_id){

            if ($entity_id !== null) {
                $where = 'entity_id = '.$entity_id;
            }
            else{
                $where = 'entity_id IS NULL';
            }
            $db->delete('user__access',
            $db->quoteInto('user_id = '.$user_id.' AND '.$where.' AND action_id = ?', $action_id));

            return true;
        }
        return false;
    }

}
