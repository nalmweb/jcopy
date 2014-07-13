<?php
/**
 * Socnet FRAMEWORK
 *
 * @package    Socnet_Data
 * @copyright  Copyright (c) 2006
 */

/**
 * Base class for all table entities.
 *
 */
class Socnet_Data_Entity
{

    /**
	 * Db connection object.
	 * @var object
	 */
    public $_db;

    /**
	 * Session object.
	 * @var object
	 */
    //public $_session;

    /**
     * The name of table which from we get data.
     * @var string
     */
    public $tableName = null;

    /**
     * Если объект не может быть загружен то устанавливаем в false
     * @var boolean
     */
    public $isExist = false;

    /**
	 * primary key name
	 * @var string
	 */
    public $pkColName = "id";

    /**
	 * Array of table's_fields => class_properties.
	 * @var array
	 */
    protected $record = array();

    /**
     * кэш для хранения загруженных объектов в пределах одного обращения к серверу
     * @var unknown_type
     */
    private $cache;

    public $EntityTypeId;
    /**
     * Constructor.
	 * @param string $tableName
     */
    public function __construct($tableName = false, $fields = null)
    {
        $this->_db = Zend_Registry::get("DB");
        //$this->_session = Zend_Registry::get("Session");
        $this->_auth = Zend_Registry::get("Auth");
        if ($tableName) $this->tableName = $tableName;
        if ($fields) $this->record = $fields;
    }
    
    /**
     * Добавление свойства в класс
     * @param string $colName
     * @param string $propertyName
     */
    public function addField($colName, $propertyName = false)
    {
        $this->record[$colName] = $propertyName ? $propertyName : $colName;

        if ($propertyName) $this->setProperty($propertyName, null);
        else $this->setProperty($colName, null);
    }

    /**
     * set value for property
     * @param string $propertyName
     * @param string $propertyValue
     * @return void
     */
    private function setProperty($propertyName, $propertyValue, $param = false)
    {
        if ( method_exists($this, 'set' . ucfirst($propertyName)) ) {
            $method = 'set' . ucfirst($propertyName);
            $this->$method($propertyValue);
        } else {
            if ( property_exists($this, $propertyName) ) {
                $this->$propertyName = $propertyValue;
            }
        }
    }

    /**
     * get value for property
     * @param string $propertyName
     * @return mixed
     */
    private function getProperty($propertyName)
    {
        if ( method_exists($this, 'get' . ucfirst($propertyName)) ) {
            $method = 'get' . ucfirst($propertyName);
            return $this->$method();
        } else {
            if ( property_exists($this, $propertyName) ) {
                return $this->$propertyName;
            } else {
                return null;
            }
        }
    }

    /**
     * return value of primary key for object
     * @return mixed
     */
    public function getPKPropertyValue()
    {
        $pkPropertyName     = $this->record[$this->pkColName];
        return $this->getProperty($pkPropertyName);
    }

    /**
     * load data to object from db
     * @param unknown_type $value
     */
    public function load($value)
    {
        if (null === $value) return false;

        if ( !is_array($value) ){
            if ( !is_object($value) ){
                $value = $this->_db->select()
                    ->from($this->tableName, '*')
                    ->where($this->pkColName . '= ? ', $value)
                    ->limit(1);
            }
            $value = $this->_db->fetchRow($value);
        }
        if ( $value ) {
            foreach ($this->record as $colName => $field) {
                if ( isset($value[$colName]) ) $this->setProperty($field, $value[$colName]);
                else $this->setProperty($field, null);
            }
            $this->isExist = true;
            return true;
        }
    }

    /**
     * load data to object by primary key
     * @param mixed $keyValue
     */
    public function loadByPk($pkValue)
    {
        if ( null === $pkValue ) return false;



        $sql = $this->_db->select()->from($this->tableName, '*')->where($this->pkColName.'=?', $pkValue)->limit(1);
        $row = $this->_db->fetchRow($sql);

        //if($this->tableName == 'catalog__model_property'){
        //  print_f($row);
        //  echo $sql->__toString();
        //}

        if ($row) {
          $i = 0 ;
            foreach ($this->record as $colName => $field) {
              $i++;
              //if($pkValue == 13 && $i >= 4)
              //  print_f('!' . $row[$colName] . '!',true);
              if ( isset($row[$colName]) ){
                $this->setProperty($field, $row[$colName]);
              }else{
                $this->setProperty($field, null);
              }
            }

            $this->isExist = true;
            return true;
        }
        return false;
    }

    /**
     * load data to object by sql
     * @param string $query
     */
    public function loadBySql($query)
    {
        $row = $this->_db->fetchRow($query);
        if ($row) {
            foreach ($this->record as $colName => $field) $this->setProperty($field, $row[$colName]);
            $this->isExist = true;
        }
    }
    
    /**
     * Сохранение объекта в базе данных
     * @todo в массив для апдейта может передать только изменённые поля, 
     * 		 сохранив первоначальные в $this->load()
     */
    public function save($table = null)
    {
        if(!is_null($table)) $this->pkColName = $table;

        foreach ( $this->record as $colName => $propertyName ) {
            if ( $propertyName != $this->pkColName ) {
                $prop[$colName] = $this->getProperty($propertyName);
            }
        }

        $pkPropertyName     = $this->record[$this->pkColName];
        if ( $this->getPKPropertyValue() ) {
            // update record
            $result = $this->_db->update(
                $this->tableName, $prop,
                $this->_db->quoteInto($this->pkColName . ' = ?', $this->getPKPropertyValue())
            );
        } else {
            // add new record, return last id and set to object
            $result = $this->_db->insert($this->tableName, $prop);
            $this->setProperty($pkPropertyName, $this->_db->lastInsertId());
        }
        return $result;

    }

    /**
     * delete record from DB
     *
     */
    public function delete()
    {
        $pkPropertyName = $this->record[$this->pkColName];
        $this->_db->delete($this->tableName, $this->_db->quoteInto($this->pkColName.' =? ', $this->getPKPropertyValue()));
    }
    
    /**
     * сохранение текущего объекта в кэш объектов
     *
     */
    public function cacheSave()
    {
        $id = $this->pkColName;
        $cache[$this->tableName][$this->$id] = $this;
    }

    /**
     * получение из кэша текущего объекта
     *
     */
    public function cacheLoad()
    {
        $id = $this->pkColName;
        //return $this = $cache[$this->tableName][$this->$id];
    }

    /**
	 * убрать из кэша текущий объект
	 *
	 */
    public function cacheDestroy()
    {
        $id = $this->pkColName;
        unset($cache[$this->tableName][$this->$id]);
    }

    public function showProperties()
    {
        print "<pre>";
        print_r($this->record);
        print "</pre>";
    }
    
    public function getTableName()
    {
    	return $this->tableName;
    }
    
}