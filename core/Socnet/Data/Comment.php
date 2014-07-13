<?php
/**
 * Socnet FRAMEWORK
 *
 * @package    Socnet_Data
 * @copyright  Copyright (c) 2006
 */

/**
 * user comment
 *
 */
class Socnet_Data_Comment extends Socnet_Data_Entity
{
    public $id;
    public $entityTypeId;
    public $entityId;
    public $ownerType;
    public $ownerId;
    public $creationDate;
    public $content;
    
    protected $_owner;
    
    /**
     * Constructor.
     *
     */
	public function __construct($id = false)
	{
	    parent::__construct('users__comments');
	    
	    $this->addField('id');
	    $this->addField('entity_type_id', 'entityTypeId');
	    $this->addField('entity_id', 'entityId');
	    $this->addField('owner_type', 'ownerType');
	    $this->addField('owner_id', 'ownerId');
	    $this->addField('creation_date', 'creationDate');
	    $this->addField('content');
	    
	    parent::loadByPk($id);
	}
	
	public function getOwner(){
	    if (!$this->_owner)
    	    switch ($this->ownerType){
    	        case 'group':
    	            $this->_owner = new Socnet_Group($this->ownerId);
    	            break;
    	        case 'user':
    	            $this->_owner = new Socnet_User($this->ownerId);
    	            break;
    	    }
	    return $this->_owner;
	}
}
?>
