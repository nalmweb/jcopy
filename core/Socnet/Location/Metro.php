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
class Socnet_Location_Metro extends Socnet_Data_Entity
{
    public $id;
    public $name;
    public $cityId;

    private $Metro;
    /**
     * Constructor.
     *
     */
	public function __construct($id = null, $key = null)
	{
        parent::__construct('location__metroes');

        $this->addField('id');
        $this->addField('name');
        $this->addField('city_id','cityId');
        
        if (null !== $key) {
        	$this->pkColName = $key;
        }
        $this->loadByPk($id);
	}
}