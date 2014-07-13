<?php
/*
 * Created on 26.12.2007
 *   Класс для работы с экипировкой. 
 */
class Socnet_Catalog_Outfit_Item extends Socnet_Data_Entity
{
	private $name;
	private $dbtree;
	private $m_table;
	
	public function __construct($table='')
	{
	  $this->m_table = isset($table)?$table:"catalog__outfit";
	  $this->dbtree = Zend_Registry::get("DBTREE");
	  $this->dbtree->setTable($this->m_table);
	}
	
	public function save ()
	{
	  //  $lastID = $oDbtree->insert($root_id,$data);	
	}	
}
?>
