<?	/**
	 * Socnet FRAMEWORK
	 *
	 * @package    Socnet_User
	 * @copyright  Copyright (c) 2006
	 */
	/**
	 *  -=- Class for Photos -=-
	 */
	class Socnet_Photo extends Socnet_Data_Entity
	{
		public $_id;
		public $id;
		public $photos_user_id;
		public $photos_album_id;
		public $comment_id;
		public $num_comments; 
		public $photos_width; // original
		public $photos_height;// original
		public $photos_title;
		public $photos_description;
		public $photos_alt;
		public $photos_registration_date;
		public $photos_picture_date;
		public $photos_order;
		public $photos_is_ok;
		public $photos_public;
		private $comments_tname = 'comment__photos';
		
		// id =>
		// что надо: get table by id.
		// set id depend on table. 
		private static $PHOTO_TYPES = array(
		  63456=>'news',
		  20920=>'photos',
		  34533=>'meetings__photos',
		  23424=>'board__bikes',
		  54535=>'ugon__bikes',
		  23092=>'board__outfit',
		  23492=>'board__details',
		  23496=>'mail__photos',
		  
		  'news'=>63456,
		  'photos'=>20920,
		  'meetings__photos'=>34533,
		  'board__bikes'=>23424,
		  'ugon__bikes'=>54535,
		  'board__outfit'=>23092,
		  'board__details'=>23492,
		  'mail__photos'=>23496
		);
		
		public static function getPhotoTableById($id){
			return isset(self::$PHOTO_TYPES[$id])?self::$PHOTO_TYPES[$id]:null;
		}
		
		public static function getIdByPhotoTable($table){
			return isset(self::$PHOTO_TYPES[$table])?self::$PHOTO_TYPES[$table]:null;
		}
		
		// 
		public function __construct()
		{
		   parent::__construct("photos");
		   $this->pkColName="id";
		   $this->addField('id');
           $this->addField('photos_user_id');
           $this->addField('photos_album_id');
           $this->addField('num_comments');
           $this->addField('photos_width');
		   $this->addField('photos_height');
           $this->addField('photos_title');
           $this->addField('photos_description');
           $this->addField('photos_alt');
           $this->addField('photos_registration_date');
           $this->addField('photos_picture_date');
           $this->addField('photos_order');
           $this->addField('photos_public');
           $this->addField('photos_is_ok');
		}
		
		public static function getPhotoTypes(){
			return self::$PHOTO_TYPES;
		}
		
		public function clearComments(){
			$data  =  array('left' => 'cleft','right' => 'cright','level' => 'clevel');
			clear($data);
		}
		
		public function setUserId(){
			
		}
		/*
			SavePhotoHereThere
		*/
		public function save()
		{
			$result = parent::save();
			
            if($result)
			{
			  $id = $this->_db->lastInsertId();
			  $this->initComment($id);
			  return $id;
			}
			else // error
				return 0;
		}
		
		/**
		 *  Insert first node for a comment (i.e. the root a tree of comments)
		 *  1 - get last id
		 *  2 - insert
		 *  3 - update parent  comment_id = new_id
		 *  @param int $id
		 */
		public function initComment($id)
		{
		 	$comment = new Socnet_Comments("photos");
		 	$comment->initComment($id);
		}
		/**
		 *  1. delete from photos_comments
		 *  2. from photos_votings (if a photo was approved and then decided to delete by User or admin)
		 *  3. from photos
		 *  4. delete file
		 *  5. update sizes for albums and photos, decrease number of photos
		 *  6. 
		 */
		public function deletePhoto($photo_id,$user_id,$album_id) 
		{
		    if(empty($photo_id) || empty($user_id) || empty($album_id)) return "Недостаточно данных для удаления";
		  // 1
		    $dbtree = Zend_Registry::get('DBTREE');
		 	$dbtree->setTable($this->comments_tname);
		 	// get photo's comment Id
		 	$sql = $this->_db->select ()->from("photos")->where ("id = ? ",$photo_id);
		 	// fdump($sql->__toString());
		 	$rs = $this->_db->fetchAll($sql);
		 	
		 	$comment_id = '';
		 	
		 	if (empty($rs))
		 		return "Фотография не существует";
		 	else 
		 	    $comment_id = $rs[0]['comment_id']; 	
		 	
		 	$dbtree->deleteAll($comment_id);
		  // 2 - not exists!
		  //$this->_db->query("DELETE FROM photos__votings WHERE id = '$photo_id' ");
		  // 3
		    $this->_db->query("DELETE FROM photos WHERE id = '$photo_id' ");
		  // 5
		   $sql = $this->_db->select ()
					  ->from ('albums')
					  ->where('albums_id = ? ',$album_id)
					  ->where('albums_user_id = ? ',$user_id);					  
           $albumItem = $this->_db->fetchAll($sql);
           // i.e. such user has album = album_id
       	   $albumSize      = $albumItem[0]['albums_size'];
       	   $albumNumPhotos = $albumItem[0]['albums_num_photos'];
		   
           $image_size = $this->getImageSpace($photo_id,$user_id,$album_id);
		   $albumSize 	  -= $image_size; // ??
   	       $albumNumPhotos--; // ??
   	       $image_size *= (-1);
   	       // -=> 4
   	       $this->removePhotoFile($photo_id,$user_id,$album_id);
		   $sql = " UPDATE albums_sizes SET total_size = total_size + $image_size WHERE user_id = $user_id";
		   $this->_db->query($sql);
		   
		   $album = array('albums_size' => $albumSize, 'albums_num_photos' => $albumNumPhotos);
   	       $this->_db->update('albums',$album,"albums_id=$album_id AND albums_user_id = $user_id");
   	       
   	       // this is that...
   	       return true;
		}
		

		/**
		 * 	Delete photos when album is being deleted
		 *  1. delete from photos_comments
		 *  2. from photos_votings (if a photo was approved and then decided to delete by User or admin)
		 *  3. from photos
		 *  4. delete file 
		 */
		function deletePhotoAndAlbum($photo_id,$user_id,$album_id){
			if(empty($photo_id) || empty($user_id) || empty($album_id)) return;
		  // 1
		    $dbtree = Zend_Registry::get('DBTREE');
		 	$dbtree->setTable($this->comments_tname);
		 	// get photo's comment Id
		 	$sql=$this->_db->select ()->from("photos")->where ("id=?",$photo_id);
		 	$rs =$this->_db->fetchAll($sql);
		 	$comment_id = '';
		 	
		 	if (empty($rs)) return false;
		 	else 
		 	    $comment_id=$rs[0]['comment_id']; 	
		 	
		 	$dbtree->deleteAll($comment_id);
 		    // 2
		    // $this->_db->query("DELETE FROM photos__votings WHERE id = '$photo_id' ");
		    // 3
		    $this->_db->query("DELETE FROM photos WHERE id = '$photo_id' ");
		    // 5
   	        $this->removePhotoFile($photo_id,$user_id,$album_id);
		}
		
		/**
		 *  1-get all photos from db
		 *  2-delete photos from table
		 *  3-delete photos from disk
		 *  4-delete album folder
		 *  5-delete album from db
		 */
		public function deleteAlbum($album_id,$user_id)
		{
		 // 1
		 $sql=$this->_db->select()->from("photos")->where("photos_album_id=?",$album_id)->where("photos_user_id=?",$user_id);
		 $photos = $this->_db->fetchAll($sql);
		 // 2,3
		 foreach ($photos as $photo)
		 {
		   $this->deletePhotoAndAlbum($photo['id'],$user_id,$album_id);
		 }
		 // sleep(10);
		 // 4
		 @rmdir(PHOTO_DIR.$user_id."/".$album_id);
		 //5 
	     $res = $this->_db->delete("albums","albums_id = '$album_id' AND albums_user_id = '$user_id' ");
	     return $res;
		}
		/**
		 * 
		 *
		 * @param unknown_type $items = {1,2,3,...,N}
		 */
		public function deletePhotos($items)
		{
		   foreach ($items as $item)
		   	   $this->deletePhoto($item);
		}
	    private function removePhotoFile($photo_id,$user_id,$album_id)
        {
   	         $md5  = md5($photo_id);
   	         $path = "$user_id/$album_id/$md5";
   	         // echo "path = $path <br> ";
  	         @unlink(PHOTO_DIR.$path."_small.jpg");
  	         @unlink(PHOTO_DIR.$path."_medium.jpg");
  	         @unlink(PHOTO_DIR.$path."_big.jpg");
  	         @unlink(PHOTO_DIR.$path.".jpg");
        }
        /*
    	//  @param: signed int $changed_size can be plus or minus
        */
        public function setTotalSize($changed_size,$user_id)
        {
           $sql = "UPDATE albums_sizes set total_size = total_size + $changed_size WHERE user_id = $user_id ";
           $this->_db->query($sql);
        }
      /*
         @return: size in KB, occupied by all pictures related to $photo_id 
      */
      function getImageSpace($photo_id,$user_id, $album_id)
      {
      	   $md5  = md5($photo_id);
      	   $s1   = @filesize(PHOTO_DIR."$user_id/$album_id/$md5"."_small.jpg");
      	   $s2   = @filesize(PHOTO_DIR."$user_id/$album_id/$md5"."_medium.jpg");
      	   $s3   = @filesize(PHOTO_DIR."$user_id/$album_id/$md5"."_big.jpg");
      	   $s1   =  ($s1 + $s2 + $s3)/1024 ; // size in KB
      	   return $s1;
      }
            
      /**
       *   check that a user updates his own title.
       *   check that title not empty
       */
      function saveTitle ($id,$title)
      {
		 $user_id = $_SESSION['user_id'];
		 $sql = $this->_db->select()
		   						->from("photos")
		   						->where(" id = ?  ",$id)
		   						->where(" photos_user_id = ?",$user_id);
		 // no such photo, OR not your photo! 
		 $rs=$this->_db->fetchAll($sql);
		 
		 if(empty($rs))
		  	return " 2 варианта: 1) фотография не существует. 2) это не ваша фотография  ";
		 
		 $values = array("photos_title"=>$title);
		 $sql = $this->_db->update("photos",$values,"id =  $id ");
		 
		 if(!empty($rs))
		 		return "OK";
		 else 
		 	 return "KO";
      }
      
      /**
       *  @return: 1 if public 
       */
      function isPublicAlbum($album_id)
      {
         $sql = $this->_db->select()->from("albums")->where("albums_id = ? ",$album_id);
         $rs  = $this->_db->fetchAll($sql);
         
         if(!empty($rs)){
         	return $rs[0]['albums_is_public'];	
         }
      }
      
    // not currently used.  
    /* +90 -> rotate right
     * -90 -> rotate left
     * 
     * @param unknown_type $gradus
     * @param unknown_type $album_id
     * @param unknown_type $user_id
     * @param unknown_type $photoId
     * @return unknown
     */
    function rotateImage($gradus, $album_id, $user_id, $photoId)
    {
    	// Copy original file to [file]_o.jpg
    	$path = PHOTO_DIR."/$user_id/$album_id/".md5($photoId);
    	$photoFile = $path.'_big.jpg';
		$newPhotoFile = str_replace(".jpg", "_o.jpg", $photoFile);
		
		if (!file_exists($newPhotoFile)){
			if (!copy($photoFile, $newPhotoFile)){
				return 0;
			}
		}
		// Rotate the original file
		$originalImage  = @imagecreatefromjpeg($photoFile);
		list($width, $height, $type, $attr) = getimagesize($photoFile);
		
		$rotated = imagerotate($originalImage,-$gradus,0);
		
		if (!imagejpeg($rotated, $photoFile, 75)){
			return 0;
		}
		
		imagedestroy($originalImage);
		@unlink($newPhotoFile);
		$this->writeThumbs($photoFile,$path);
		
		$photoSRC = str_replace(PHOTO_DIR, "http://".BASE_HTTP_HOST."/uploads/user_photos", $photoFile);
		$photoSRC = str_replace("\\", "/", $photoSRC);
		$photoSRC = str_replace("_big.jpg","_medium.jpg",$photoSRC);
		// $photoSRC = $photoSRC."?".rand(1, 1000);
		list($width, $height, $type, $attr) = getimagesize($photoFile);
		$res=array($photoSRC,$width,$height);
	  return $res;
    }
    
    public static function UnsharpMaskImage($img, $amount = 80, $radius = 0.5, $threshold = 3 )
    {
    /*

New: 
- In version 2.1 (February 26 2007) Tom Bishop has done some important speed enhancements.
- From version 2 (July 17 2006) the script uses the imageconvolution function in PHP 
version >= 5.1, which improves the performance considerably.


Unsharp masking is a traditional darkroom technique that has proven very suitable for 
digital imaging. The principle of unsharp masking is to create a blurred copy of the image
and compare it to the underlying original. The difference in colour values
between the two images is greatest for the pixels near sharp edges. When this 
difference is subtracted from the original image, the edges will be
accentuated. 

The Amount parameter simply says how much of the effect you want. 100 is 'normal'.
Radius is the radius of the blurring circle of the mask. 'Threshold' is the least
difference in colour values that is allowed between the original and the mask. In practice
this means that low-contrast areas of the picture are left unrendered whereas edges
are treated normally. This is good for pictures of e.g. skin or blue skies.

Any suggenstions for improvement of the algorithm, expecially regarding the speed
and the roundoff errors in the Gaussian blur process, are welcome.

*/

////////////////////////////////////////////////////////////////////////////////////////////////  
////  
////                  Unsharp Mask for PHP - version 2.1.1  
////  
////    Unsharp mask algorithm by Torstein Hønsi 2003-07.  
////             thoensi_at_netcom_dot_no.  
////               Please leave this notice.  
////  
///////////////////////////////////////////////////////////////////////////////////////////////  



    // $img is an image that is already created within php using 
    // imgcreatetruecolor. No url! $img must be a truecolor image. 

    // Attempt to calibrate the parameters to Photoshop: 
    if ($amount > 500)    $amount = 500; 
    $amount = $amount * 0.016; 
    if ($radius > 50)    $radius = 50; 
    $radius = $radius * 2; 
    if ($threshold > 255)    $threshold = 255; 
     
    $radius = abs(round($radius));     // Only integers make sense. 
    if ($radius == 0) { 
        return $img; imagedestroy($img); break;        } 
    $w = imagesx($img); $h = imagesy($img); 
    $imgCanvas = imagecreatetruecolor($w, $h); 
    $imgBlur = imagecreatetruecolor($w, $h); 
     

    // Gaussian blur matrix: 
    //                         
    //    1    2    1         
    //    2    4    2         
    //    1    2    1         
    //                         
    ////////////////////////////////////////////////// 
         

    if (function_exists('imageconvolution')) { // PHP >= 5.1  
            $matrix = array(  
            array( 1, 2, 1 ),  
            array( 2, 4, 2 ),  
            array( 1, 2, 1 )  
        );  
        imagecopy ($imgBlur, $img, 0, 0, 0, 0, $w, $h); 
        imageconvolution($imgBlur, $matrix, 16, 0);  
    }  
    else {  

    // Move copies of the image around one pixel at the time and merge them with weight 
    // according to the matrix. The same matrix is simply repeated for higher radii. 
        for ($i = 0; $i < $radius; $i++)    { 
            imagecopy ($imgBlur, $img, 0, 0, 1, 0, $w - 1, $h); // left 
            imagecopymerge ($imgBlur, $img, 1, 0, 0, 0, $w, $h, 50); // right 
            imagecopymerge ($imgBlur, $img, 0, 0, 0, 0, $w, $h, 50); // center 
            imagecopy ($imgCanvas, $imgBlur, 0, 0, 0, 0, $w, $h); 

            imagecopymerge ($imgBlur, $imgCanvas, 0, 0, 0, 1, $w, $h - 1, 33.33333 ); // up 
            imagecopymerge ($imgBlur, $imgCanvas, 0, 1, 0, 0, $w, $h, 25); // down 
        } 
    } 

    if($threshold>0){ 
        // Calculate the difference between the blurred pixels and the original 
        // and set the pixels 
        for ($x = 0; $x < $w-1; $x++)    { // each row
            for ($y = 0; $y < $h; $y++)    { // each pixel 
                     
                $rgbOrig = ImageColorAt($img, $x, $y); 
                $rOrig = (($rgbOrig >> 16) & 0xFF); 
                $gOrig = (($rgbOrig >> 8) & 0xFF); 
                $bOrig = ($rgbOrig & 0xFF); 
                 
                $rgbBlur = ImageColorAt($imgBlur, $x, $y); 
                 
                $rBlur = (($rgbBlur >> 16) & 0xFF); 
                $gBlur = (($rgbBlur >> 8) & 0xFF); 
                $bBlur = ($rgbBlur & 0xFF); 
                 
                // When the masked pixels differ less from the original 
                // than the threshold specifies, they are set to their original value. 
                $rNew = (abs($rOrig - $rBlur) >= $threshold)  
                    ? max(0, min(255, ($amount * ($rOrig - $rBlur)) + $rOrig))  
                    : $rOrig; 
                $gNew = (abs($gOrig - $gBlur) >= $threshold)  
                    ? max(0, min(255, ($amount * ($gOrig - $gBlur)) + $gOrig))  
                    : $gOrig; 
                $bNew = (abs($bOrig - $bBlur) >= $threshold)  
                    ? max(0, min(255, ($amount * ($bOrig - $bBlur)) + $bOrig))  
                    : $bOrig; 
                 
                 
                             
                if (($rOrig != $rNew) || ($gOrig != $gNew) || ($bOrig != $bNew)) { 
                        $pixCol = ImageColorAllocate($img, $rNew, $gNew, $bNew); 
                        ImageSetPixel($img, $x, $y, $pixCol); 
                    } 
            } 
        } 
    } 
    else{ 
        for ($x = 0; $x < $w; $x++)    { // each row 
            for ($y = 0; $y < $h; $y++)    { // each pixel 
                $rgbOrig = ImageColorAt($img, $x, $y); 
                $rOrig = (($rgbOrig >> 16) & 0xFF); 
                $gOrig = (($rgbOrig >> 8) & 0xFF); 
                $bOrig = ($rgbOrig & 0xFF); 
                 
                $rgbBlur = ImageColorAt($imgBlur, $x, $y); 
                 
                $rBlur = (($rgbBlur >> 16) & 0xFF); 
                $gBlur = (($rgbBlur >> 8) & 0xFF); 
                $bBlur = ($rgbBlur & 0xFF); 
                 
                $rNew = ($amount * ($rOrig - $rBlur)) + $rOrig; 
                    if($rNew>255){$rNew=255;} 
                    elseif($rNew<0){$rNew=0;} 
                $gNew = ($amount * ($gOrig - $gBlur)) + $gOrig; 
                    if($gNew>255){$gNew=255;} 
                    elseif($gNew<0){$gNew=0;} 
                $bNew = ($amount * ($bOrig - $bBlur)) + $bOrig; 
                    if($bNew>255){$bNew=255;} 
                    elseif($bNew<0){$bNew=0;} 
                $rgbNew = ($rNew << 16) + ($gNew <<8) + $bNew; 
                    ImageSetPixel($img, $x, $y, $rgbNew); 
            } 
        } 
    } 
    imagedestroy($imgCanvas); 
    imagedestroy($imgBlur);
    
    return $img;
   }

    /**
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
    static public function removePhoto($table,$item_id,$photo_id, $bRemove = true ){
    	
    	$path = "";
    	
    	switch($table){
    		case 'news':
    			$path = NEWS_DIR.md5($photo_id);
    			break;
    		case 'board__bikes':
    		case 'board__details':
    		case 'board__outfit':
    		    $path = BOARD_PHOTOS.$item_id."/".md5($photo_id);
    			break;
    			
    		case 'mail__photos':
    		    $path = MAIL_PHOTOS.$item_id."/".md5($photo_id);
    			break;    	
    					
    		case 'ugon_bikes':
    		    $path = UGON_PHOTOS.$item_id."/".md5($photo_id);
    			break;
    		case 'meetings__created':
    		    $path = MEETINGS_PHOTOS.$item_id."/".md5($photo_id);
    			break;
    	}
    	
    	@unlink($path.".jpg");
    	@unlink($path."_small.jpg");
    	@unlink($path."_medium.jpg");
    	@unlink($path."_big.jpg");
    
    	if($bRemove){
    		$db  = Zend_Registry::get("DB");
    		$table .= "__photos";
    		$sql = $db->query(" DELETE FROM $table where id ='$photo_id' ");
    	}
    }
    
    /**
     *   @param: $table_name : news | board | 
     */
    static public function isOwner($table_name, $item_id){
/*    	$tables = array (
    	   'ugon' =>  'ugon__bikes',
    	   'board' => 'board__bikes', // 
    	)*/
    	$user_id 	 = $_SESSION['user_id'];
    	//$table_name .= ;
		$user_col = '';
		if( $table_name == "news" ){
			$user_col = 'news_user_id';
		}
		else if($table_name=="meetings__photos"){
			$user_col = 'photos_user_id';
		}   
		else if($table_name=="mail__templates"){
			$user_col = 'creator_id';
		}
		else{
		  $user_col = 'user_id';	  
		}
    	// Socnet_Photo:
    	$db  = Zend_Registry::get("DB");
    	$sql = $db->select()->from($table_name,"id")->where("id = ? ", $item_id )->where("$user_col = ? ",$user_id);
    	// dump($sql);
    	$rs  = $db->fetchCol($sql);
    	
    	if(!empty($rs)) 
    		return true;
    	return false;
    }
}
?>