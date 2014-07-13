<?php
class Socnet_UserComments extends Socnet_Data_Entity  
{
		private $id;
		public $who_user_id ;
		public $whom_user_id;
		public $registration_date;
		
		function __construct(){
		   
		   parent::__construct("comment__user_list");
		   $this->addField('id');
		   $this->addField('who_user_id');
           $this->addField('whom_user_id');
           $this->addField('registration_date');
		}
		
		public function save(){
			parent::save();
		}
		// 
		public function canComment($who_id,$whom_id){
			// can't do for himself
			if($who_id == $whom_id)
				return false;
			
			$sql=$this->_db->select()
								->from("comment__user_list")
								->where("whom_user_id = ? ",$whom_id)
								->where("who_user_id = ? ",$who_id );
			// echo $sql->__toString();
			$res = $this->_db->fetchOne($sql);								
			if(empty($res)) return true;
			else return false;
		}
}
?>
