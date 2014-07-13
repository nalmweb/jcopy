<?php
/*
 *  This is that now.
 */
 class Socnet_Mail_Status_Item extends Socnet_Data_Entity 
 { 	
 	public $id;
 	public $user_id;
 	public $item_id;
 	public $is_sent;
    public $reg_date;
    
 	public function __construct($table=null){ 	   
 	   if(empty($table)) 
 	   			$table='mail__status';
 	   			
 	   parent::__construct($table);
	   $this->addField('id');
	   $this->addField('user_id','userId'); 
	   $this->addField('item_id','itemId');
	   $this->addField('is_sent','isSent');
	   $this->addField('reg_date','date');
	   $this->pkColName = 'id';
 	}
 	
 	public function setUserId($id){
 	  $this->user_id=$id;	
 	}
 	public function setItemId($id){
 	  $this->item_id=$id;	
 	}
	public function setId($id){
		$this->id=$id;
	} 	
	public function setIsSent($bool){
		$this->is_sent=$bool;
	}	
	public function setDate($date){
		$this->reg_date=$date;
	} 		
 	
 	public function getId(){
 		return $this->id;
 	}
 	public function getUserId(){
 		return $this->user_id;
 	}
 	public function getItemId(){
 		return $this->item_id;
 	}
 	public function getIsSent(){
 		return $this->is_sent;
 	}
 	public function getDate(){
 		return $this->reg_date;
 	}
 	public function save(){
 		parent::save(); 		
 	}
 }
?>
