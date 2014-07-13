<?php
/*
   Created on 26.12.2007
   Select list of values
*/ 
 class Socnet_Catalog_Outfit_List 
 {
 	private $dbtree;
 	private $db;
 	private $m_table;
 	
 	public function __construct()
 	{
 	   $this->dbtree=Zend_Registry::get("DBTREE");
 	   $this->db=Zend_Registry::get("DB");
 	   $this->m_table="catalog__outfit";
 	}
 	
 	/**
 	 *  Шлемы, куртки и т.п.
 	 */ 
 	public function getTypes()
 	{
 	  $sql=$this->db->select()->from("catalog__outfit",array("cid","title"))->where("clevel=?",1);
 	  $pairs = $this->db->fetchPairs($sql);
 	  
 	  if(!empty($pairs))
 	  	return $pairs;
 	  return null;
 	}
 	
 	/**
 	 *  Get all element's children.
 	 */
 	public function getKinds($id)
 	{
	   $this->dbtree->setTable($this->m_table);	
 	   $childs=$this->dbtree->justGetChildren($id,1,2);
 	   $ret='';
 	   
 	   if(!empty($childs))
 	   {
 	      foreach($childs as $value)
 	         $ret[$value['cid']]=$value['title'];
 	      return $ret;
 	   }
 	   return null;	
 	}
 } 
?>