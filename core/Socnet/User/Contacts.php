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
class Socnet_User_Contacts extends Socnet_Data_Entity
{
    public $id;
    public $skype;
    public $icq;
    public $msn;
    public $livejournal;
    public $homepage;
    public $phone;

    private $Contact;
    /**
     * Constructor.
     *
     */
	public function __construct($id = null)
	{
        parent::__construct('user__contacts');

        $this->addField('id');
        $this->addField('skype');
        $this->addField('icq');
        $this->addField('msn');
        $this->addField('livejournal');
        $this->addField('homepage');
        $this->addField('phone');
        $this->loadByPk($id);
	}

}