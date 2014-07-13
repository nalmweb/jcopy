<?php
/*
 * Created on 13.12.2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */ 
 class Socnet_Board_Photo extends Socnet_Data_Entity
 {
  private $category_id;
  
  public $id; 
  public $cat_id;
  public $item_id; 
  public $alt; 
  public $width;
  public $height;
  public $reg_date;
  private $m_table="board__photos";
  private $allowedNumberOfPhotos=5;  
  private $photosPaths = array ( '1' =>'bikes','2'=>'details','3'=>'outfit' );
  
  // the number of photos related to and item_id
  private $numPhotos;
  private $imageList;  
 	
  public function __construct ($id='')
  {
	parent::__construct($this->m_table);
	
    $this->pkColName="id";
    $this->addField('id');
    $this->addField('cat_id', 'catId');
    $this->addField('item_id','itemId');
    $this->addField('alt');
    $this->addField('width');
    $this->addField('height');
    
    if(null !== $id){
    	$this->loadByPk($id);
    }
  }
  // 
  public function getId(){
 	 return $this->id;
  }

  public function setId($id){
 	 $this->id=$id;
  }
  
  public function setCatId($catId){
  	$this->cat_id= $catId;
  }
  
  public function setItemId($itemId){
  	$this->item_id=$itemId;
  }
  
  public function getItemId(){
  	return $this->item_id;
  }
  
  public function getCatId(){
  	return $this->cat_id;
  }

  // 
  public function save(){
  	$result = parent::save();
  	
  	if(empty($this->id)){
		return $this->_db->lastInsertId();
  	}
	return $this->id;
  }
  
  /**
  *  @param: $id - ad's id
  */
 public function savePhotos($item_id,$cat_id,$bUpdate=false){
 	// echo "cat_id=".$this->cagegory_id;
 	// dump($_POST);
 	// dump($_FILES);
 	$width='';
 	$height='';
 	ini_set('gd.jpeg_ignore_warning', 1);
 	
	for($i=0; $i< $this->allowedNumberOfPhotos; $i++)
	{
	  if(isset ($_FILES['photo_'.$i])) 
	   if(0 == $_FILES['photo_'.$i]['error'])
	   {
	    $temp_path = $_FILES['photo_'.$i]['tmp_name'];
	    
	    list($width, $height, $type, $attr)=getimagesize($temp_path);
	    // smth like check for valid image.
	    if(empty($width)||empty($type))continue;
	    
	     $photo_id=0;
	     
	     if(!$bUpdate)
	     {
			$this->id=0;
		    $this->cat_id=$cat_id;
		    $this->width =$width;
		    $this->height=$height;
		    $this->alt	 ="";
		    $this->item_id=$item_id;
	 		$this->reg_date=date("Y-m-d H:i:s", time());
		    $photo_id=$this->save();
	     }
	     else{
	   	   $photo_id = $this->getId();  
	     }    
        
        $subfolder = isset($this->photosPaths[$cat_id])?$this->photosPaths[$cat_id]:1;
        $path = BOARD_PHOTOS."/$subfolder/$item_id/".md5($photo_id);
        
        if(!empty($photo_id))
        {
			$file = $_FILES['photo_'.$i]['tmp_name'];
	        $aInfo = array();
	        $aInfo[0]['width'] =$width;
	        $aInfo[0]['height']=$height;
	        $aInfo[0]['path']  =$path.'_big.jpg';
	        
			$aInfo[1]['width'] =500; 	
	        $aInfo[1]['height']=500;
	        $aInfo[1]['path']  =$path.'_medium.jpg';
	        
			$aInfo[2]['width'] =250;
	        $aInfo[2]['height']=250;
	        $aInfo[2]['path']  =$path.'_small.jpg';
	        
	        $aInfo[3]['width'] =128;
	        $aInfo[3]['height']=128;
	        $aInfo[3]['path']  =$path.'.jpg';
	        /*dump($aInfo);
	        exit;*/
	        Socnet_Thumbnail::saveImages($file,$width,$height,$aInfo);
	        $aInfo =null;
        }        
	  }
	}
 }
 
 // 
 public function getList($item_id,$cat_id){
 	$sql   = $this->_db->select()->from($this->m_table)
 				  ->where("item_id=?",$item_id)->where("cat_id=?",$cat_id);
 	$items = $this->_db->fetchPairs($sql);
 	return $items;	
 }
 
  public function getImageList()
  {
   		if(!empty($this->imageList)) 
	   			return $this->imageList;
	   
	   $sql=$this->_db->select()->from($this->m_table)
	   				  ->where("item_id=?",$this->item_id)
	   				  ->where("cat_id =?",$this->cat_id);
	   $rs =$this->_db->fetchAll($sql);
       $count=0;
       
	   if(!empty($rs)){
		 $subfolder=isset($this->photosPaths[$this->cat_id])?$this->photosPaths[$this->cat_id]:1;
		 
		 foreach($rs as $photo){		 	
		    $path=BOARD_WEBPHOTOS.$subfolder.'/'.$this->item_id."/".md5($photo['id']);
		    $this->imageList[$count]['id']=$photo['id'];
		 	$this->imageList[$count]['thumb']=$path.'.jpg';
		 	$this->imageList[$count]['small']=$path.'_small.jpg';
		 	$this->imageList[$count]['medium']=$path.'_medium.jpg';
		 	$this->imageList[$count]['big']=$path.'_big.jpg';
		 	$this->imageList[$count]['alt']=$photo['alt'];
		 	$count++;
		 }
	   }
	   $this->setNumPhotos($count);
	   return $this->imageList;
  }
 
  public function setNumPhotos($num){
   	 $this->numPhotos =$num;
  }
  public function getNumPhotos()
  {
   	  if(empty($this->numPhotos)){
   	  	  $sql = $this->_db->select()->from($this->m_table,'COUNT(*)')
   	  	  				   ->where ('item_id =?',$this->item_id)
   	  	  				   ->where ('cat_id  = ? ',$this->cat_id);
		  $this->numPhotos = $this->_db->fetchOne($sql);
   	  }
   	  return $this->numPhotos;
  }
}
?>