<?php
abstract class Socnet_Abstract_List 
{
	/**
	 * DB Connection object
	 */
	protected $_db;
	/**
	 * Current Page for list
	 */
	protected $_currentPage;
	/**
	 * number of items per page
	 */
	protected $_listSize = MIN_NUMBER_LINE;
	/**
	 * order string for results
	 */
	protected $_order;
	/**
	 * return results as assoc
	 */
	protected $_asAssoc = false;
	
	/**
	 * name of db field for assoc array key
	 */
	protected $_assocKey;
	
	/**
	 * name of db field for assoc array value
	 */
	protected $_assocValue;

	protected $_where;

    protected $_includeIds;

    protected $_excludeIds;

	public function  __construct()
	{
		$this->_db = Zend::registry("DB");
	}

    public function getCurrentPage()
    {
        return $this->_currentPage;
    }

    public function setCurrentPage($page)
    {
    	if ( !is_numeric($page) || $page < 1 ) $page = 1;
        $this->_currentPage = $page;
        return $this;
    }

    public function getListSize()
    {
        return $this->_listSize;
    }

    public function setListSize($size)
    {
    	if ( !is_numeric($size) || $size < 1 ) $size = 1;
        $this->_listSize = $size;
        return $this;
    }

    public function getOrder()
    {
        return $this->_order;
    }

    public function setOrder($order)
    {
        $this->_order = $order;
        return $this;
    }

    public function returnAsAssoc($mode = true)
    {
    	$this->_asAssoc = (boolean) $mode;
    	return $this;
    }

    public function isAsAssoc()
    {
    	return (boolean) $this->_asAssoc;
    }
    
    public function setAssocKey($fieldName)
    {
    	$this->_assocKey = $fieldName;
    	return $this;
    }

    public function getAssocKey()
    {
    	return $this->_assocKey;    	
    }
 
    public function setAssocValue($fieldName)
    {
        $this->_assocValue = $fieldName;
        return $this;
    }

    public function getAssocValue()
    {
        return $this->_assocValue;
    }
  
    public function getWhere()
    {
        if ( $this->_where === null ) return '';
        else return join(' ', $this->_where); 
    }

    public function addWhere($cond)
    {
        if (func_num_args() > 1) {
            $val = func_get_arg(1);
            $cond = $this->_db->quoteInto($cond, $val);
        }
        if ($this->_where) {
            $this->_where[] = 'AND ' . $cond;
        } else {
            $this->_where[] = $cond;
        }
        return $this;
    }
 
    public function addWhereOr($cond)
    {
        if (func_num_args() > 1) {
            $val = func_get_arg(1);
            $cond = $this->_db->quoteInto($cond, $val);
        }
        if ($this->_where) {
            $this->_where[] = 'OR ' . $cond;
        } else {
            $this->_where[] = $cond;
        }
        return $this;
    }

    public function clearWhere()
    {
    	$this->_where = null;
    }
    
    public function setIncludeIds($newVal)
    {
    	if ( !is_array($newVal) ) $newVal = array($newVal);
    	$this->_includeIds = $newVal;
    	return $this;
    }
 
    public function getIncludeIds()
    {
    	return $this->_includeIds;
    }
   
    public function setExcludeIds($newVal)
    {
        if ( !is_array($newVal) ) $newVal = array($newVal);
        $this->_excludeIds = $newVal;
        return $this;
    }

    public function getExcludeIds()
    {
        return $this->_excludeIds;
    }

    public function resetList()
    {
        $this->_currentPage    = null;
        $this->_listSize       = null;
        $this->_asAssoc        = false;
        $this->_assocKey       = null;
        $this->_assocValue     = null;
        $this->_excludeIds     = null;
        $this->_includeIds     = null;
        $this->_listSize       = null;
        $this->_membersRole    = null;
        $this->_membersStatus  = null;
        $this->_order          = null;
        $this->clearWhere();
        return $this;
    }
 
    abstract public function getList();
 
    abstract public function getCount();
}