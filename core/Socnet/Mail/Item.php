<?php
/*  
   an item that creates mail templates.
*/ 
 class Socnet_Mail_Item extends Socnet_Data_Entity {
 	
 	public $id;
    public $template_key;
    public $creatorId;
    public $changerId;
    public $createDate;
    public $changeDate;
    public $description;
    public $content;
    // для удобства
    private $text_part;
    private $html_part;
    private $imageList;
    // public $message;
    private $photos_table = "mail__photos"; 	
 	
	public function __construct($key = null, $val = null)
	{
		parent::__construct('mail__templates');

		$this->addField('id');
		$this->addField('template_key','templateKey');
		$this->addField('creator_id','creatorId' );
		$this->addField('changer_id','changerId' );
		$this->addField('creation_date','createDate');
		$this->addField('change_date','changeDate');
		$this->addField('description');
		$this->addField('content');

	    if( null !== $key )
        {
          $this->pkColName='id';
          $this->loadByPk($key);          
	    }
	}
	
	public function setId($id){
		$this->id=$id;
	}
 	public function setTemplateKey ($val) {
 		$this->template_key =$val; 
 	} 
 	
 	public function setCreatorId ($val) { 		
 		$this->creatorId =$val;
 	} 

 	public function setChangerId ($val) {
 		$this->changerId=$val;
 	} 

 	public function setCreateDate ($val) { 		
 		$this->createDate = $val;
 	} 

 	public function setChangeDate ($val) {
		$this->changeDate = $val;
 	}
 	
 	public function setDescription ($val) {
		$this->description= $val;
 	}
 	
 	public function setContent ($val) {
 	   $this->content = $val;
 	}
 	
 	public function combineContent(){
 		$this->content=$this->text_part . $this->html_part;
 	}
 	
 	// 
 	public function setTextPart($text){
 		$this->text_part;
 	}
 	
 	public function setHtmlPart($html){
 		$this->html_part;
 	}

	// GeTTers 	
	
	public function getId() { return $this->id; }
	
 	public function getTemplateKey (){
 		return $this->template_key; 
 	} 
 	
 	public function getCreatorId (){
 		return $this->creatorId;
 	} 

 	public function getChangerId (){
 		return $this->changerId;
 	} 

 	public function getCreateDate (){ 		
 		return $this->createDate;
 	} 

 	public function getChangeDate (){
		return $this->changeDate  ;
 	}
 	
 	public function getDescription (){
		return $this->description ;
 	}
 	
 	public function getContent (){
 	   return $this->content;
 	}
 	// 
 	public function getTextPart($text){
 		return $this->text_part;
 	}
 	public function getHtmlPart($html){
 		return $this->html_part;
 	}
 	
 	public function save()
 	{
 		parent::save();
 	}
 	
   /**
	 *  Enter description here...
	 */
	public function savePhoto($id)
	{		  
	  for ($i=0; $i<5; $i++)
	  {
		 if(0 == $_FILES['photo_'.$i]['error'] && !empty($id) )
		 {
		   $photo = new Socnet_Mail_Photo();
		   list($width, $height, $type, $attr) = getimagesize($_FILES['photo_'.$i]['tmp_name']);
		   
		   $photo->item_id   = $id;
		   $photo->width     = $width;
		   $photo->height    = $height;
		   		   
		   $photo_id = $photo->save();
		   // echo " photo_id =$photo_id";
		   //  path:
		   $path = MAIL_PHOTOS.$id.'/'.md5($photo_id).".jpg";	       
		   $file =$_FILES['photo_'.$i]['tmp_name'];
		   
		   Socnet_Image_Thumbnail::makeThumbnail($file,$path,$width,$height);
		 }
	   }
	}
 	
 	public function getImageList()
    {
	   if(!empty($this->imageList)) 
	   	   return $this->imageList;
	   
	   $sql=$this->_db->select()->from($this->photos_table)->where("item_id=?",$this->id);
	   $rs =$this->_db->fetchAll($sql);
       $res=array();
       
	   if(!empty($rs))
	   {
		 $count=0;
		 
		 foreach($rs as $photo){
		    $path=MAIL_PHOTOS.md5($photo['id']);
		 	$this->imageList[$count]['thumb']=$path.'.jpg';
		 	$count++;
		 }
	   }
	   return $this->imageList;
    }
 }
?>
