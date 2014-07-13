<?php
/*
   Responsible for saving info about mail broadcasts ( информация по рассылкам )
*/
 class Socnet_Mail_Broadcast extends Socnet_Data_Entity
 {
   public  $id; 
   public  $title; 
   public  $template_key; 
   public  $reg_date;
   
   
   private $m_table="mail__broadcast"; 
 	
   public function __construct(){
 	   
 	   $this->pkColName = 'id';
 	   parent::__construct($this->m_table);
	   $this->addField('id');	 
	   $this->addField('title');
	   $this->addField('template_key','templateKey');
	   $this->addField('reg_date','date');
 	}
 	
 	public function setTemplateKey($id){
 	  $this->template_key=$id;	
 	}
	public function setId($id){
		$this->id=$id;
	}
	public function setTitle($title){
		$this->title=$title;
	}	
	public function setDate($date){
		$this->reg_date=$date;
	}
 	public function getId(){
 		return $this->id;
 	}
 	public function getTitle(){
 		return $this->title;
 	}
 	public function getTemplateKey(){
 		return $this->template_key;
 	}
 	public function getIsSent(){
 		return $this->is_sent;
 	}
 	public function getDate(){
 		return $this->reg_date;
 	}
 	public function save(){
 		parent::save();
 		return $this->_db->lastInsertId();
 	} 
 	
 	public function getList($key="",$date="")
 	{
 	   /*$select = $this->_db->select()->from(array( 't1' => $this->m_table))
 		->joinLeft(array('t2' => 'mail__templates'), " t1.template_key = t2.id ",array("id","template_key")); 		
 		$sql ='';
 		if(!empty($key))
 		{
 		  $sql = " AND t1.template_key=$key";
 		}
 		if(!empty($date)){ 		   
 		   $sql .= " AND t1.reg_date = $date "; 
 		}
 		$sql = "1 ".$sql;
 		//echo $sql;
 		$select->where($sql);
 	    $rs = $this->_db->fetchAll($select);
 	  */
 	  
 	  $sql = "SELECT t1.*,t2.id,t2.template_key as template_name,t3.item_id, count(t3.item_id) as num_users
FROM      mail__broadcast t1 left join mail__templates t2 on t1.template_key = t2.id
left join mail__status t3 on t1.id = t3.item_id where 1 group by t3.item_id " ;
 	  
		//echo $sql;
		$rs = $this->_db->fetchAll($sql);
 	    //dump($rs);
 	    return $rs;
 	}
}
?>