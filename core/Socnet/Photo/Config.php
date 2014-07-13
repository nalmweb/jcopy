<?php
/*
 * Created on 11.06.2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 class Socnet_Photo_Config 
 {
 	private $type;
 	private $item_id;
 	private $photo_id;
 	private static $type_name;
 	private static $type_id;
 	
 	static public $MAIL = 23496;
 	static public $BOARD_BIKES  = 23424;
 	static public $BOARD_OUTFIT = 23425;
 	static public $BOARD_DETAILS= 23426;
 	static public $NEWS 	= 63456;
 	static public $MEETINGS = 34533;
 	static public $UGON 	= 54535;
 	 	 	
 	public static $PHOTO_TYPES = array(
		  63456=>'news',
		  20920=>'photos',
		  34533=>'meetings__created',
		  23424=>'board__bikes',
		  54535=>'ugon__bikes',
		  23425=>'board__outfit',
		  23426=>'board__details',
		  23496=>'mail__templates',
		  'news'=>63456,
		  'photos'=>20920,
		  'meetings__created'=>34533,
		  'board__bikes'=>23424,
		  'ugon__bikes'=>54535,
		  'board__outfit'=>23425,
		  'board__details'=>23426,
		  'mail__templates'=>23496
		);
		
    public static $PHOTO_TABLES = array (
    	  63456=>'news__photos',
		  20920=>'photos',
		  34533=>'meetings__photos',
		  23424=>'board__photos',
		  23425=>'board__photos',
		  23426=>'board__photos',   
		  54535=>'ugon__photos',
		  23092=>'board__photos',
		  23492=>'board__details__photos',
		  23496=>'mail__photos',
		  
		  'news'=>'news__photos',
		  'photos'=>'photos',
		  'meetings__created'=>'meetings__photos',
		  'board__bikes'=>'board__photos',
		  'board__details'=>'board__photos',
		  'board__outfit'=>'board__photos',
		  'ugon__bikes'=>'ugon_photos',		  
		  'mail__templates'=>'mail__photos'
    );
	/**
	 *  @param: $id - 63456 | 20920 | ... 
	 * 
	 */	
	public static function getPhotoTableById($id){
		return isset(self::$PHOTO_TYPES[$id])?self::$PHOTO_TYPES[$id]:null;
	}
	
	public static function getIdByPhotoTable($table){
		return isset(self::$PHOTO_TYPES[$table])?self::$PHOTO_TYPES[$table]:null;
	}
	
	static public function setTypeId($id){
		self::$type_id=$id;
		self::$type_name=self::$PHOTO_TABLES[self::$type_id]; 
	}
	
	static public function setTypeName($name){
		self::$type_name=$name;
		// set also type_id by name
	}
	
   /* 	
 	 *   @param: $type - news | board | ugon | meetings | photos - a table name
     *   paths:
     * 		  news    :  NEWS_DIR.$md5(photo_id).".jpg" 
     *  	  board   :  BOARD_PHOTOS.$item_id."/".md5($photo['id']);
     *  	  ugon    :  UGON_PHOTOS."/$item_id/".md5($photo_id);
     * 		  meetings:  MEETINGS_PHOTOS."$item_id/md5($photo_id)"."_small.jpg")
     *  
     * 		  photos  :  PHOTO_DIR."/$user_id/$album_id/".md5($photoId);
     *  
     *   @param: $item_id  -
     *   @param: $photo_id -
     *   @param: $bRemove  - if to remove data from DB.   
     * 
     *   откуда взять $table при удалении фото?
     *  
     */ 
    static public function removePhoto($item_id,$photo_id, $bRemove = true ){
    	$path = "";
    	// echo "[".self::$type_id;
    	switch(self::$type_id){
    		
    		case self::$NEWS:
    		case 'news':
    			$path = NEWS_DIR.md5($photo_id);
    			break;
    			
    		case self::$BOARD_BIKES:	
    		case 'board__bikes':
    			$path = BOARD_PHOTOS.'bikes/'.$item_id."/".md5($photo_id);
    			break;
    			
    		case self::$BOARD_DETAILS:	
    		case 'board__details':
    			$path = BOARD_PHOTOS.'details/'.$item_id."/".md5($photo_id);
    			break;
    			
    		case self::$BOARD_OUTFIT:	
    		case 'board__outfit':
    		    $path = BOARD_PHOTOS.'outfit/'.$item_id."/".md5($photo_id);
    			break;
    			
    		case self::$MAIL:	
    		case 'mail__photos':
    		    $path = MAIL_PHOTOS.$item_id."/".md5($photo_id);
    			break;    	
    					
		    case self::$UGON:    					
    		case 'ugon_bikes':
    		    $path = UGON_PHOTOS.$item_id."/".md5($photo_id);
    			break;
    			
    		case self::$MEETINGS:	
    		case 'meetings__created':
    		    $path = MEETINGS_PHOTOS.$item_id."/".md5($photo_id);
    			break;
    	}
    	
    	@unlink($path.".jpg");
    	@unlink($path."_small.jpg");
    	@unlink($path."_medium.jpg");
    	@unlink($path."_big.jpg");
    	
    	// echo $path;
    	if($bRemove){
    		$db    = Zend_Registry::get("DB");
    		$table = self::$PHOTO_TABLES[self::$type_id];
    		$sql = " DELETE FROM $table where id ='$photo_id' ";
    		$db->query($sql);
    	}
    }
    
    /**
     *    
     */
    static public function removeDir($item_id){
			
		switch(self::$type_id)
		{	
			case self::$BOARD_BIKES:	
    		    	$path=BOARD_PHOTOS.'bikes/'.$item_id."/";
    			break;
    			
    		 case self::$BOARD_DETAILS:
    		    	$path=BOARD_PHOTOS.'details/'.$item_id."/";
    			break;
    			
			 case self::$BOARD_OUTFIT:
    		    	$path=BOARD_PHOTOS.'outfit/'.$item_id."/";
    			break;    					
    			
    		case self::$MAIL:	
    		    	$path=MAIL_PHOTOS.$item_id."/";
    			break;    	
    					
		    case self::$UGON:    					
    		    	$path=UGON_PHOTOS.$item_id."/";
    			break;
    			
    		case self::$MEETINGS:
    				$path=MEETINGS_PHOTOS.$item_id."/";
    			break;	
		}
		@rmdir($path);
    }
    /**
     * 
     *  @return: The path to the file.
     */
    static public function getPathByName($item_id,$photo_id){
    	switch(self::$type_name){
		   case 'news': return NEWS_DIR.md5($photo_id);
		   		break;
		   case 'photos':
		   		break;
		   case 'meetings__photos':
		   		break;
		   case 'ugon__bikes':
		   		  return  UGON_PHOTOS.$item_id."/".md5($photo_id);
		   		break;
		   case 'board__bikes':
		   		break;		   		
		   case 'board__outfit':
		   		break;		   
		   case 'board__details':
		   		break;
    		case 'mail__photos':
    		    $path = MAIL_PHOTOS.$item_id."/".md5($photo_id);
    			break;
    	}
    }
    
    /**
     *  @return: photo object by type name.
     */
    static public function getObject(){
    	switch(self::$type_id){
    	   case 23496:
    		    return new Socnet_Mail_Photo_Item();
    		  break;
    	}    	
    }
    /**
     *   @param: $table_name : news | board |
     *  
     */
    static public function isOwner($type_name, $item_id,$cat_id = 0){
	/*  
	    $tables = array (
    	   'ugon' =>  'ugon__bikes',
    	   'board' => 'board__bikes', // 
    )*/
    	self::$type_name = $type_name;
    	$user_id 	 = $_SESSION['user_id'];
    	//$table_name .= ;
		$user_col = '';
		
		switch(self::$type_name)
		{
		  case 'news': $user_col = 'news_user_id'; break;
			  
		  case 'meetings__photos': $user_col = 'photos_user_id'; break;
		  case 'mail__photos':
		  case 'mail__templates':
			$user_col = 'creator_id';
			break;
			
		  		
			
		 default:
		 		$user_col = 'user_id';
		 	break;
		}
    	// Socnet_Photo:
    	$db  = Zend_Registry::get("DB");
    	
    	$sql = '';
    	
    	/*if(self::$type_id==23424 || self::$type_id==23425 || self::$type_id== 23426)
    	{
 		  // check that user own that item.
 		  $sql = $db->select()->from("board__bikes","id")->where("id = ? ", $item_id )
 		  								->where("$user_col = ? ",$user_id)
 		  								->where("cat_id = ?",$cat_id);
    	}
    	else{*/
    	$sql = $db->select()->from(self::$type_name,"id")->where("id = ? ", $item_id )
    													 ->where("$user_col = ? ",$user_id);
    	// }
    	// dump($sql);
    	$rs  = $db->fetchCol($sql);
    	
    	if(!empty($rs)) 
    		return true;
    	return false;
    } 	
    
    /**
     *   JS for photos ( for the changePhotoDialog and deleting the photo.)
     */
    static public function getJS(){
 		$js = "<script language='javascript' src='/js/window_lib.js'></script> ".
        "<script language='javascript' src='/js/window_ext.js'></script>  " .
        "<script language='javascript' src='/js/photos.js'></script>" .
        "<script type='text/javascript' src='/js/swfupload/swfupload.js'></script>".
		"<script type='text/javascript' src='/js/swfupload/handlers.js'></script>"  ;
		return $js;
    }
    
    /**
     * 
     *   must be arbitrary number of params
     *   @return: the action that uploads the photo. 
     */
    static function getAction($item_id,$cat_id=null){

	// static public $MAIL = 23496;
 	// static public $MEETINGS = 34533;
    	switch(self::$type_id)
    	{
    	  case self::$NEWS:
    			return "/users/editNews/id/$item_id/";
    		 break;
    		 	
		  // THe same for all board types
		  case  self::$BOARD_BIKES:
		  		return "/users/adsEdit/cat/{$cat_id}/item/{$item_id}/";
		  	break;
		  	
		  case  self::$UGON:
		  		return "/users/ugonEdit/item/$item_id/";
		    break;		
    	}
    }
 }
?>
