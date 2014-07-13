<?php
/*

*/
 class Socnet_MailStatus extends Socnet_Data_Entity 
 { 	
 	public $id;
 	public $user_id;
 	public $template_key;
 	public $is_sent;
    public $reg_date;
 	
 	public function __construct($table){ 		
 	   
 	   if(empty($table)) 
 	   			$table='user__mail';
 	   			
 	   parent::__construct($table);
	   $this->addField('id');
	   $this->addField('user_id','userId'); 
	   $this->addField('template_key','templateKey');
	   $this->addField('is_sent','isSent');
	   $this->addField('reg_date','date');
	   $this->pkColName = 'id';
 	}
 	
 	public function setUserId($id){
 	  $this->user_id=$id;	
 	}
 	
 	public function setTemplateKey($id){
 	  $this->template_key=$id;	
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
 	}
 }
?>
