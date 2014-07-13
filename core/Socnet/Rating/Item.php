<?php

class Socnet_Rating_Item extends Socnet_Data_Entity
{
  public $id; 
  public $type;
  public $user_id; 
  public $comment_id; 
  public $reg_date;
  
  
  private $sType;

  private $sections = array(
   'news' 	=> 1,
   'photos' => 2,
   'meetings__created'=>3,
   'meetings__photos' =>4,
   'user' => 5
  );
  
  /*
  private $sections= array(
   'news' => array('name'=>'news','value'=>1),
   'photos' => array('name'=>'photo','value'=>2),
   'meetings__created' => array('name'=>'meetings__created','value'=>3),
   'meetings__photos' => array('name'=>'meetings__photos','value'=>4),
   'user' => array('name'=>'user','value'=>1),
   
'1' => 'news',
'2' => 'photos',
'3' => 'meetings__created',
'4' => 'meetings__photos',
'5' => 'user'
  ) ;*/

 private $m_table = "comment_rating"; 

  public function __construct(){

     parent::__construct($this->m_table);
 	 $this->addField('id');
 	 $this->addField('type');
 	 $this->addField('user_id');
 	 $this->addField('comment_id');
 	 $this->addField('reg_date');
  }
  
  /**
   *   @return: types's id to save into table
   */
  public function getTypeId($name){
  	 
  	 if(array_key_exists($name,$this->sections)){
  	   return $this->sections[$name];	
  	 }
  	 return 0;
  }
 
  public function setType($sType){
  	$this->sType=$sType;
  	$this->type = $this->getTypeId($sType);
  }
  
  public function setUserId($user_id){
  	 $this->user_id = $user_id;
  }
  
  public function setCommentId($id){
  	$this->comment_id = $id;
  }
  
  public function save(){  	
  	 parent::save();
  }
  
  // 
  public function isRated($type,$cid,$user_id)
  {
    $type_id =$this->getTypeId($type);
    $sql     ="SELECT * from $this->m_table where type=$type_id and comment_id = $cid and user_id = $user_id ";    
    $rs 	 =$this->_db->fetchOne($sql);
    
    // dump($rs);
    if(!empty($rs))
	    return true;
	return false;
  }
  
  /*
   *  @return: new rating value
   */
  public function updateRating($sign){
  	 // get rating
  	 $sql = " select rating from comment__$this->sType where cid = $this->comment_id " ;
  	 $rating  = $this->_db->fetchOne($sql);
  	 $rating+=$sign;
  	 $sql = " update comment__$this->sType set rating=$rating where cid = $this->comment_id";
  	 $this->_db->query($sql);
  	 return $rating;
  }
}
?>
