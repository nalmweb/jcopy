<?php
/*
     
*/ 
class Socnet_Mail_Photo extends Socnet_Data_Entity
{
  public $id;
  public $item_id; 
  public $alt; 
  public $width;
  public $height;
  public $reg_date;
  
  private $m_table = "mail__photos";
 	
  public function __construct ($id=null)
  {
	parent::__construct($this->m_table);
    $this->pkColName="id";
    $this->addField('id');
    $this->addField('item_id','itemId');
    $this->addField('alt');
    $this->addField('width');
    $this->addField('height');
    $this->addField('reg_date','date');
    
  	if(null !== $id){
    	$this->loadByPk($id); 
    }
  }
  public function getId(){
		return $this->id;
  }
	
  public function getItemId(){
		return $this->item_id;
  }
	
  public function getWidth(){
		return $this->width;
  }
	
	public function getHeight(){
		return $this->height;
	}
	
	public function getAlt (){
		return $this->alt;
	}
	
	public function setId($val){
		$this->id=$val;
	}	
	
	public function setItemId($val){
		$this->item_id=$val;
	}
	
	public function setWidth($val){
		$this->width=$val;
	}
	
	public function setHeight($val){
		$this->height=$val;
	}
	
	public function setAlt ($val){
		$this->alt=$val;
	}
	
	public function setDate($date){
	  $this->reg_date = $date;
	}
	public function getDate(){
		return $this->reg_date;
	}
	
    public function save()
    {
  	  $result = parent::save();
  	  if($result){
		 return $this->_db->lastInsertId();
  	  }
	  else{
	      // echo "res=[$res],id-".$this->_db->lastInsertId();
	   return 0;
	  }
   }   
   
/*   public function savePhotos($file)
   {
   	   $path = MAIL_PHOTOS."/".$this->getItemId()."/".md5($this->getId());
   	   
   	   $web_path= '';
   	   
   	   $width  = $this->getWidth ();
   	   $height = $this->getHeight();
   	   
       if(!empty($this->id))
       {			
	        $aInfo = array();
	        $aInfo[0]['width'] = $width;
	        $aInfo[0]['height']= $height;
	        $aInfo[0]['path']  = $path.'.jpg';
		
			$aInfo[1]['width'] =500;
	        $aInfo[1]['height']=500;
	        $aInfo[1]['path']  =$path.'_medium.jpg';
	        
			$aInfo[2]['width'] =250;
	        $aInfo[2]['height']=250;
	        $aInfo[2]['path']  =$path.'_small.jpg';
	        
	        $aInfo[3]['width'] =128;
	        $aInfo[3]['height']=128;
	        $aInfo[3]['path']  =$path.'.jpg';
	     	        
	        Socnet_Thumbnail::saveImages($file,$width,$height,$aInfo);
	        $web_path = MAIL_WEBPHOTOS."/".$this->getItemId()."/".md5($this->getId()).".jpg";
        }
        return $web_path;
   }*/
   
    public function savePhotos ()
    {
    	  //dump($_FILES);
	      $item_id = $this->getItemId();
		  for ($i=0; $i<=7; $i++)
		  {
		    if (isset($_FILES['photo_'.$i]))
			 if(0 == $_FILES['photo_'.$i]['error'] && !empty($item_id) )
			 {
			   $file =$_FILES['photo_'.$i]['tmp_name'];
			   
			   $photo_id = 0;
			   
			   list($width, $height, $type, $attr) = getimagesize($_FILES['photo_'.$i]['tmp_name']);

			   $this->id =0;
			   $this->width   = $width;
			   $this->height  = $height;
			   $photo_id = $this->save();
			   //echo " photo_id =$photo_id";
			   $path  = MAIL_PHOTOS.$this->item_id."/".md5($photo_id);
			   //echo $path."<br />";
			   $aInfo = array();
		       $aInfo[0]['width'] =$width;
		       $aInfo[0]['height']=$height;
		       $aInfo[0]['path']  =$path.'.jpg';
			   Socnet_Thumbnail::saveImages($file,$width,$height,$aInfo);
			 }
		}
    }
      
   /** 
    *  @return: returns the path to the dir with files. 
    */
   public function getPath($item_id=null){
      if(!empty($item_id)){
        return MAIL_PHOTOS.$item_id."/";
      }
      else{
      	return MAIL_PHOTOS.$this->item_id."/";
      }
   }
   
   
   
}
?>
