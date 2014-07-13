<?php

class Socnet_Mail_Message extends Socnet_Data_Entity
{
    public $id;
    public $creatorId;
    public $changerId;
    public $createDate;
    public $changeDate;
    public $content;
    public $description;

    private $Creator        = null;
    private $Changer        = null;
    /**
     * Constructor.
     */
	public function __construct($id = null)
	{
		parent::__construct('mailtemplates__messages');

		$this->addField('id');
		$this->addField('creator_id', 'creatorId');
		$this->addField('changer_id', 'changerId');
		$this->addField('creation_date','createDate');
		$this->addField('change_date','changeDate');
		$this->addField('content');
		$this->addField('description');

		if ($id !== null){
	        $this->pkColName = 'id';
	        $this->loadByPk($id);
		}
	}
	/**
	 * Set Creator for message
	 * @return void
	 */
	public function setCreator()
	{
       $this->Creator = new Socnet_User('id',$this->creatorId);
	}
	/**
	 * Get Creator for message
	 * @return obj - Socnet_User
	 */
	public function getCreator()
	{
	    if ( $this->Creator === null ) {
	        $this->setCreator();
	    }
	    return $this->Creator;
	}
	/**
	 * Set Changer for message
	 */
	public function setChanger()
	{
       $this->Changer = new Socnet_User('id',$this->changerId);
	}
	/**
	 * Get Changer for message
	 * @return obj - Socnet_User
	 */
	public function getChanger()
	{
	    if ( $this->Changer === null ) {
	        $this->setChanger();
	    }
	    return $this->Changer;
	}
}
