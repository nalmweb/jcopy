<?php
/*
 * Created on 13.12.2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */ 
 class Socnet_BoardPhoto extends Socnet_Data_Entity
 {
  private $category_id;
  
  public $id; 
  public $cat_id;
  public $item_id; 
  public $alt; 
  public $width;
  public $height;
  public $reg_date;
 	
  public function __construct ()
  {
	parent::__construct("board__photos");
    $this->pkColName="id";
    $this->addField('id');
    $this->addField('cat_id');
    $this->addField('item_id');
    $this->addField('alt');
    $this->addField('width');
    $this->addField('height');
  }
  
  // this is that man!
  public function save()
  {
  	$result = parent::save();
  	if($result)
  	{
		return $this->_db->lastInsertId();
  	}
	else
	{
	  //echo "res=[$res],id-".$this->_db->lastInsertId();
	  return 0;
	}
  }
  
  /**
  *  @param: $id - ad's id
  */
 public function savePhotos($item_id,$cat_id)
 {
 	//echo " cat_id=".$this->cagegory_id;
 	$size=5;
 	$width='';
 	$height='';
 	
 	ini_set('gd.jpeg_ignore_warning', 1);
 	
	for($i=0; $i<$size;$i++)
	{
	   if(0 == $_FILES['photo_'.$i]['error'])
	   {
	    $temp_path = $_FILES['photo_'.$i]['tmp_name'];
	    
	    list($width, $height, $type, $attr)=getimagesize($temp_path);
	    // smth like check for valid image.
	    if(empty($width)||empty($type))continue;
	    $this->id=0;
	    $this->cat_id=$cat_id;
	    $this->width=$width;
	    $this->height=$height;
	    $this->alt="";
	    $this->item_id=$item_id;
 		$this->reg_date=date("Y-m-d H:i:s", time());
	    $photo_id=$this->save();
        
        $path = BOARD_PHOTOS."/$item_id/".md5($photo_id);
        
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
        /*
        // use BOARD_PHOTOS in path! 
 		$path = "./upload/board_photos/$item_id/".md5($photo_id);
        //$temp_path = $_SERVER['DOCUMENT_ROOT']."/upload/output.jpg";
        //@unlink($temp_path);
        $w=128;$h=96;
        //$cmd="convert -resize ${w}x$h $file $temp_path";
        //passthru($cmd);
        //passthru(" cp ".$_FILES['photo_'.$i]['tmp_name']." ./upload/photo.jpg");
        Socnet_Thumbnail::makeThumbnail ($temp_path,$path.'_small.jpg',128,96);        
        //@unlink($temp_path);
        $w=500;$h=375;
        //$cmd="convert -resize ${w}x$h $file $temp_path";
        //passthru($cmd);
        Socnet_Thumbnail::makeThumbnail ($temp_path,$path.'_medium.jpg',500,375);
        //@unlink($path);
        $h=$height;$w=$width;
        //$cmd="convert -resize ${w}x$h $file $temp_path";
        //passthru($cmd);
        $path = Socnet_Thumbnail::makeThumbnail ($temp_path,$path.'_big.jpg',$width,$height);
         */
	   }
	}
 }
}
?>
