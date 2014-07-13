<? 
 /* @TODO:  
   Fatal error: Allowed memory size of 16777216 bytes exhausted (tried to allocate 4928 bytes) 
    in /usr/Gentoo.APP/apache2/docs/motofriendsru_beta/www/core/Socnet/Thumbnail.php on line 132 
    - была такая ошибка   
  */ 
   /*
	  Usage:
Socnet_Thumbnail::makeThumbnail ($_FILES['photo_'.$i]['tmp_name'],$path.'_small.jpg',75,75,MEETINGS_PHOTOS);
Socnet_Thumbnail::makeThumbnail ($_FILES['photo_'.$i]['tmp_name'],$path.'_medium.jpg',400,400,MEETINGS_PHOTOS);
Socnet_Thumbnail::makeThumbnail ($_FILES['photo_'.$i]['tmp_name'],$path.'_big.jpg',0,0,MEETINGS_PHOTOS)
    create and  resize images
	  
	  @input: image and sizes.
	  	  1) convert & resize
	  2) move to Location
  */
  class Socnet_Thumbnail 
  {
      static private $maxX = 600;
      static private $maxY = 800;
      
      static private $workImage=''; 
      static private $workImageInfo='';
      static private $workImagePath=''; 
 	  /*
 	  	  small:  75x75
 	   	  medium: 
 	  */
  	  public function __construct()
  	  {
  	  
  	  }
  	  
	  /*
	     @purpose::
				   Prepare image, Set SizeS. Any image type is converted into JPEG
	     @param: $img 	     -> Image File
	     @param: $width  	 -> width
	     @param: $height		 -> height
	     
	  	 @todo: check size before adding and image.
	  	        size can be specified by for each user!
	  	        
	  	 if mediumX < maxX and mediumY < maxY :: no matter
	  	 
	  	 @return: a path to the file
	  	 
	  	 как насчет того, если изображение слишком маленькое?
	  */
	  // this a manager function
	  /**
	   *   $aSizes =array (
	   * 				0 => array('width'=>,'height'=>) big 
	   * 				1 => array('width'=>,'height'=>) medium
	   * 				2 => array('width'=>,'height'=>) small
	   *  )
	   *   
	   *  create big from original  
	   * 
	   *  optimize it: 
	   *     smaller photos must be done from bigger photos
	   * 
	   *  @problems:the order is not correct: first small, then big.
	   *  @mustbe:  900,500,100
	   * 
	   */ 
	  static function saveImages($sourcePath,$width,$height,$aSizes,$addBorder=false,$borderColor="255,255,255")
	  {
	  	 ini_set('memory_limit', '128M');
	  	 // check(); // check photos
	  	 /*if(!LOCALHOST)
	  	 {
	  	  	$sourcePath=self::resize($sourcePath,$width,$height); 
	  	  	// resize temp file a bit with [convert]   convert source -resize width-1xheight-1 output
	  	 }*/
	  	 /**
	  	  *   @in: resized photo.
	  	  *   
	  	  */ 
	  	  // create path to save photos: /user_photos/user_id/... and set 777
	  	  self::createPath($aSizes[0]['path'],0777);
	  	  self::setWorkImagePath(null);	  	  
	  	  // работать с уменьшенным файлом.
		  $i=0;
	  	  foreach ( $aSizes as $photo )
	  	  {
		    $photo = $aSizes[$i];
		    // dump($photo);
	  	    // IN case target sizes > source sizes.
	  	    if($width<$photo['width'])
	  	    {
	  	    	if($height<$photo['height'])
	  	    	{
	  	    	  self::makeThumbnail($sourcePath,$photo['path'],$width-1,$height-1,$addBorder=false,$borderColor="255,255,255");
	  	    	}
	  	    	// only width
	  	    	else
	  	    	{
	  	    		self::makeThumbnail($sourcePath,$photo['path'],$width,$photo['height'],$addBorder=false,$borderColor="255,255,255");	
	  	    	}
	  	    }
	  	    self::makeThumbnail($sourcePath,$photo['path'],$photo['width'],$photo['height'],$addBorder=false,$borderColor="255,255,255");
	  	    /*echo "after make: <br>";
	  	    dump(self::$workImage);*/
	  	    //dump(self::$workImageInfo);
	  	    $i++;
	  	  }
	  	  //imagedestroy(self::getWorkImage());
	  	  ini_set('memory_limit', '16M');
	  	  // self::createPath($thumbnailPath,0755);
	  	  //exit;
	  }
	  
	  static private function setWorkImage($image){
	  	  self::$workImage=$image;
	  }
	  static private function getWorkImage() { return self::$workImage; }
	  
	  static private function setWorkImagePath($path){
	  	self::$workImagePath=$path;
	  }
	  
	  private static function getWorkImagePath () {  return self::$workImagePath?self::$workImagePath:null; }
	  
	  /**
	       Set the following information:
          	[0] => 320
	     	[1] => 240
    		[2] => 2
    		[3] => width="320" height="240"
    		[bits] => 8
	    	[channels] => 3
    		[mime] => image/jpeg
	   */
	  private static function setWorkImageInfo($info)
	  {
	  	 self::$workImageInfo=$info;
	  }
	  
	  private static function getWorkImageInfo (){
	  	 return self::$workImageInfo;
	  }
	  
	  /**
	   *  resize photo a bit to fix it with GD usage.
	   *  maybe after that - will use Imagick :-)
	   *  cp /tmp/file /tmp/file_md5(time) 
	   * 
	   *  @param: $width  -original width
	   *  @param: $height -original height 
	   */
	  static function resize($sourcePath,$width,$height)
	  {
	  	  $file_name = basename($sourcePath);
	  	  $time=md5(strftime("%Y-%m-%d %H:%M:%S",time()));
      	  $tmp_path  = $sourcePath."_". $time;
      	  
      	  $width-=1;
      	  $height-=1;
      	  
      	  $dest= $_SERVER['DOCUMENT_ROOT']."/upload/user_photos/".md5($time.$_SESSION['user_id'].$width)."_.jpg";
      	  // $cmd= "convert $sourcePath -resize ${width}x$height $tmp_path";
      	  $cmd= "convert $sourcePath -resize ${width}x$height $dest";
          passthru($cmd);
          
          return $dest;
	  }
	  /**
	   *  
	   *   @return: 
	   */
	  static function makeThumbnail ($sourcePath, $thumbnailPath,$targetWidth,$targetHeight,$addBorder = false,$borderColor="255,255,255")
	  {
	  	$targetWidth     = floor($targetWidth);
        $targetHeight    = floor($targetHeight);
        $addBorder       = (bool)$addBorder;
        $borderColor     = $borderColor;
        $result          = "ok";
	  	
	  	/*Get image size */
	  	$sourceSize='';
	  	
	  	if(!empty (self::$workImagePath))
	  	{
	  	   $sourcePath = self::getWorkImagePath();
	  	}
        $sourceSize = getimagesize($sourcePath);
        // dump($sourceSize);
        /*}
        else
        {
        	$sourceSize = self::getWorkImagePa();
        }*/
        
        if (false === $sourceSize) {
            $result = "невозможно получить размер изображения";
            return $result;
        }
        // dump($sourceSize);
        /**
          	[0] => 320
	     	[1] => 240
    		[2] => 2
    		[3] => width="320" height="240"
    		[bits] => 8
	    	[channels] => 3
    		[mime] => image/jpeg
         */
		// exit;
	  	//Check image type using MIME info
        $format = strtolower(substr($sourceSize['mime'], strpos($sourceSize['mime'], '/')+1));
        $icfunc = "imagecreatefrom" . $format;
        
        if (!function_exists($icfunc)) {
            $result = "функция ($icfunc) не существует";
            return $result;
        }
        
        // SET IMAGE INFORMAION!
        // self::setWorkImageInfo($sourceSize);
        
        $thumbnailPic='';
        //$work=getWorkImage();
        $thumbnailPic=@$icfunc($sourcePath); 
        /*
        if (  empty (self::$workImage)  )
        {
        	// 
        	// $sourcePic was used together with resized
        	// $sourcePic=@$icfunc($sourcePath);
        	
        	echo "1st time:";
        	dump($thumbnailPic);
        	// dump($sourcePic);
        }
        else
        {
        	echo " <br /> 2nd time: ";
        	// $sourcePic = self::$workImage;
        	$thumbnailPic = self::$workImage;
        	dump($thumbnailPic);
        } 	*/
        //print $sourcePic." <br>";
        
        if ($thumbnailPic == ""){
            $result = "невозможно применить данную функцию $icfunc ";
            return $result;
        }
        
        $width  = $targetWidth;    // thumbnail width
        $height = $targetHeight;   // thumbnail height
        $bwidth = $sourceSize[0];  // initial image width
        $bheight= $sourceSize[1];  // initial image height
        
	  /*         
 		if ($addBorder) {
            $rgb = explode(",", $borderColor);

            if ($bwidth < $width){//add border
                $temp = imagecreatetruecolor($width, $bheight);
                $white = imagecolorallocate($temp, $rgb[0], $rgb[1], $rgb[2]);
                imagefilledrectangle($temp, 0,0,$width, $bheight, $white);
                imagecopyresized($temp, $sourcePic, ($width - $bwidth)/2, 0, 0, 0, $bwidth, $bheight, $bwidth, $bheight);
                $bwidth = $width;
                $sourcePic = $temp;
            }

            if ($bheight < $height){//add border
                $temp = imagecreatetruecolor($bwidth, $height);
                $white = imagecolorallocate($temp, $rgb[0], $rgb[1], $rgb[2]);
                imagefilledrectangle($temp, 0,0, $bwidth, $height, $white);
                imagecopyresized($temp, $sourcePic, 0, ($height - $bheight)/2, 0, 0, $bwidth, $bheight, $bwidth, $bheight);
                $bheight = $height;
                $sourcePic = $temp;
            }
        }*/
        // 3000 / 500 = 6
        $scaleX = $bwidth / $width;
        // 2000 /500 = 4
        $scaleY = $bheight / $height;

        if (  $scaleY >= $scaleX )
        {
            $newWidth = $bwidth / $scaleY;
            $newHeight = $height;
        }
        else
        {
            $newWidth = $width;
            $newHeight = $bheight / $scaleX;
        }
	    // fdump($width,$height);
	    // resize image to fit thumbnail
        // $thumbnailPic = imagecreatetruecolor($newWidth, $newHeight);
        // то есть, сейчас у нас фото размерами: 768x500 к примеру
        // имеет смысл, если фото > 2000?
        
        // imagecopyresized($thumbnailPic,$sourcePic, 0, 0, 0, 0, $newWidth, $newHeight, $bwidth, $bheight);        
        // self::setWorkImage($thumbnailPic);
        // should save memory
        // imagedestroy($sourcePic);
		// $temp = '';        	    
        	    
		// create image with dest sizes 500x500 for inst.
		if($newWidth >= $width)
		{        	    
			// echo "this! <br> ";
			$temp=imagecreatetruecolor($width, $newHeight);
		}
		else if($newHeight >= $height)
			$temp=imagecreatetruecolor($newWidth, $height);
		else		
			$temp=imagecreatetruecolor($width, $height);
		/*if($newWidth > $width)
		{        	    
           /// $temp = imagecreatetruecolor($width, $height);
           $temp = imagecreatetruecolor($newWidth, $height);
		}
		else
		{
		   if($newHeight > $height)
		   		$temp = imagecreatetruecolor($width, $newHeight);
		   else 
		   	    $temp = imagecreatetruecolor($width, $height); // 500x500
		}*/
		// делать уменьшение пропорциональное, да?
        /**
         *  $newWidth: 
         *  width:128,250,500
         *   если новая > конечного?
         *    New > 500 
         */
        // echo "w=[$width], newWidth[$newWidth], newH=[$newHeight]m h=[$height] <br> ";
		// imagecopyresampled($temp, $thumbnailPic, 0, 0, 0, 0, $width, $height, $newWidth, $newHeight);
        if ($newWidth >= $width)
        {
          // resource dst_im, src_im, dstX,dstY,srcX,srcY,dstW,dstH,srcW,srcH
          //imagecopyresampled($temp, $thumbnailPic, 0, 0, ($newWidth-$width)/2, 0, $width, $height, $width, $newHeight);
          /**
              берем из $thumbnailPic
              и сохраняем в $temp размерами [500x358]
           */
		  imagecopyresampled($temp, 	 // dst_image 
		  					 $thumbnailPic, // src_im 
		  					 0, // dstX
		  					 0, // dstY
		  					 0, // srcX
		  					 0, // srcY
		  					 $width,     //dstWidth
		  					 $newHeight, //dstHeight
		  					 $bwidth,
		  					 $bheight
		  					 //$newWidth,  //srcWidth  -> convert to 500
		  					 //$newHeight  //srcHeight -> newHeight=358
		  					 );
        }
        // y:600 > 500 x:450
        // 
        else if ($newHeight >= $height)
        {
           imagecopyresampled($temp,$thumbnailPic, 0, 0, 0, 0,
           							$newWidth, // thumb width
           							$height,   // thumb height
           							$bwidth,
           							/*$newWidth,*/// srcWidth
           							$bheight
           							/*$newHeight*/ // srcHeight
           					 );
        }
        // newHeight>height or newWidth < width;
        else
        {
          // imagecopyresampled($temp, $thumbnailPic, 0, 0, 0,($newHeight-$height)/2, $width, $height, $newWidth, $height);
          imagecopyresampled($temp, $thumbnailPic, 0, 0, 0, 0, 
          									$newWidth,
          									$newHeight,
          									$bwidth,
          									$bheight);
        }
        /*
          Нашел как оптимизировать немного :)
после
imagecopyresized($thumbnailPic,$sourcePic, 0, 0, 0, 0, $newWidth, $newHeight, $bwidth, $bheight);
поставьте
imagedestroy($sourcePic);
так уменьшите количество требуемой памяти на 30-50% :)          
         */
        // self::setWorkImage($temp);
        
        // imagejpeg($temp, $thumbnailPath,100);        
	    ImageJPEG($temp,$thumbnailPath,99);
		//echo "path = $thumbnailPath <br>";
		
        if (!file_exists($thumbnailPath)){
            $result = "Не могу создать файл";
            return $result;
        }
        self::setWorkImagePath($thumbnailPath);
        /**
         *   почему, когда я делаю setImage, то в след. раз говорят, что это не image?
         */
        imagedestroy($temp);
        imagedestroy($thumbnailPic);
        // return $result;
        // exit;
        return $thumbnailPath;
	  }
	  
	  static function makeThumbnail_old($img,$path,$width, $height,$path_prefix="")
	  {
	    $targetWidth     = floor($targetWidth);
        $targetHeight    = floor($targetHeight);
        $addBorder       = (bool)$addBorder;
        $borderColor     = $borderColor;
        $result          = "ok";
	     
	     // echo "path = $path <br> ";
	     $src_img = '';	
	     $dst_img = '';
	     
	     $size = getimagesize ($img);
	     
	     /*Get image size */
         $sourceSize = getimagesize($sourcePath);
          
         if (false === $sourceSize)
         {
           $result = "cant get image size";
           return $result;
         }
	     
	     ini_set('memory_limit', '40M');
	     
	     /*switch ($size[2])
	     {
	  	  case 1:
	  			$src_img=ImageCreateFromGif($img);
	  		break;
	  	  case 2:
	  			$src_img=ImageCreateFromJpeg($img);
	  		break;
	  	  case 3:
	  			$src_img=ImageCreateFromPng($img);
	  		break;
	  	  case 6: 
	  			$src_img=ImageCreateFromBmp($img);
	  		break;
	  	  // what about flash?
	  	  default:
	  		break;
	     }*/

	     // Get image width
	    $srcWidth    = ImageSX($src_img);
	    // get height
	    $srcHeight   = ImageSY($src_img);
	    
	    $ratioWidth  =1;
	    $ratioHeight =1;
	        
	    if($width == 1 && $height == 1 )
        {
            if($srcWidth >self::$maxX || $srcHeight > self::$maxY)
            {
            	$destWidth  = 1 ; 
            	
            	$ratioWidth  = $srcWidth/self::$maxX;
		    	$ratioHeight = $srcHeight/$height;	
            	
                if($srcWidth > self::$maxX)
                {
	                   $ratioWidth  = $srcWidth/self::$maxX;
	                   $destWidth  = $srcWidth/$ratioHeight;
                }
                
	            if($srcHeight > self::$maxY)
	            {
	                  $ratioHeight = $srcWidth/self::$maxY;
	                  $destHeight = $srcHeight/$ratioWidth;
	            }
            }
            else
            {
               $ratioWidth  = $srcWidth;
               $ratioHeight = $srcHeight;
            }
        }
	        
	    elseif(!empty($width) && !empty($height) )
	    {
		    $ratioWidth  = $srcWidth/$width;
		    $ratioHeight = $srcHeight/$height;
			   
		   if($ratioWidth < $ratioHeight)
		   {
			  $destWidth  = $srcWidth/$ratioHeight;
			  $destHeight = $height;
		   }
		   else
		   {
		  	  $destWidth = $width;
		  	  $destHeight = $srcHeight/$ratioWidth;
		   }
		   
		   if ( $size[0] >= $destWidth and $size[1] >= $destHeight )
				$dst_img=ImageCreatetruecolor($destWidth,$destHeight);
		   else
	   	   {
		  	   $dst_img=ImageCreatetruecolor($size[0],$size[1]);
		  	   $destWidth=$size[0];
		  	   $destHeight=$size[1];
	   	   }
	    }
	    // The largest one:
	    else
	    {
	       $destHeight =  $srcHeight;
	   	   $destWidth  =  $srcWidth;
	   	   
	   	   //echo " "
	       $dst_img=ImageCreatetruecolor($srcWidth,$srcHeight);
	    }
	     
	     $i_sx = ImageSX($src_img);
	     $i_sy = ImageSY($src_img);
	     ImageCopyResampled($dst_img,$src_img,0,0,0,0, $destWidth, $destHeight, $i_sx,$i_sy);
	     
	     ini_set('memory_limit', '16M');
	     @chmod($path_prefix,0777);	     
		 self::createPath($path,0777);
	     ImageJPEG($dst_img,$path,95);
	     self::createPath($path,0755);
	     @chmod($path_prefix,0755);
	     
	     return $path;
      }
      
      
	/**
     * @param string $sourcePath - source image path
     *
     * @param string $thumbnailPath - thumbnail path
     *
     * @param integer $targetWidth - thumbnail width
     *
     * @param integer $targetHeight - thumbnail height
     *
     * @param boolean $addBorder - draw border and leave initial size of image, if thumbnail size bigger than it.
     *
     * @param string $borderColor - string representation of RGB color for border. format R,G,B
     *
     * @param string $result - contain result of convertion. ok - if all right, or error message;
     *
     */

    static function makeThumbnail2222($sourcePath, $thumbnailPath, $targetWidth = 0, $targetHeight = 0, $path_prefix="", $addBorder = false, $borderColor = "255,255,255")
    {
        $targetWidth     = floor($targetWidth);
        $targetHeight    = floor($targetHeight);
        $addBorder       = (bool)$addBorder;
        $borderColor     = $borderColor;
        $result          = "ok";
        /*Get image size */
        $sourceSize = getimagesize($sourcePath);
        if (false === $sourceSize) {
            $result = "cant get image size";
            return $result;
        }

        //Check image type using MIME info
        $format = strtolower(substr($sourceSize['mime'], strpos($sourceSize['mime'], '/')+1));
        $icfunc = "imagecreatefrom" . $format;

        if (!function_exists($icfunc)) {
            $result = "function ($icfunc) isnt exist";
            return $result;
        }

        $sourcePic = @$icfunc($sourcePath);
        //print $sourcePic." <br>";
        if ($sourcePic == "") {
            $result = "cant apply $icfunc function";
            return $result;
        }

        $width = $targetWidth;  //thumbnail width
        $height = $targetHeight;//thumbnail height
        $bwidth = $sourceSize[0]; 	    //initial image width
        $bheight = $sourceSize[1];    //initial image height

        //add border to image
        if ($addBorder) {
            $rgb = explode(",", $borderColor);

            if ($bwidth < $width){//add border
                $temp = imagecreatetruecolor($width, $bheight);
                $white = imagecolorallocate($temp, $rgb[0], $rgb[1], $rgb[2]);
                imagefilledrectangle($temp, 0,0,$width, $bheight, $white);
                imagecopyresized($temp, $sourcePic, ($width - $bwidth)/2, 0, 0, 0, $bwidth, $bheight, $bwidth, $bheight);
                $bwidth = $width;
                $sourcePic = $temp;
            }

            if ($bheight < $height){//add border
                $temp = imagecreatetruecolor($bwidth, $height);
                $white = imagecolorallocate($temp, $rgb[0], $rgb[1], $rgb[2]);
                imagefilledrectangle($temp, 0,0, $bwidth, $height, $white);
                imagecopyresized($temp, $sourcePic, 0, ($height - $bheight)/2, 0, 0, $bwidth, $bheight, $bwidth, $bheight);
                $bheight = $height;
                $sourcePic = $temp;
            }
        }
        
        //resize
        $scaleX = $bwidth / $width;
        $scaleY = $bheight / $height;

        if ($scaleX > $scaleY){
            $newWidth = $bwidth / $scaleY;
            $newHeight = $height;
        } else {
            $newWidth = $width;
            $newHeight = $bheight / $scaleX;
        }

        $thumbnailPic = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresized($thumbnailPic,$sourcePic, 0, 0, 0, 0, $newWidth, $newHeight, $bwidth, $bheight);

        $temp = imagecreatetruecolor($width, $height);
        if ($newWidth > $width){
            imagecopyresampled($temp, $thumbnailPic, 0, 0, ($newWidth-$width)/2, 0, $width, $height, $width, $newHeight);
        } else {
            imagecopyresampled($temp, $thumbnailPic, 0, 0, 0, ($newHeight-$height)/2, $width, $height, $newWidth, $height);
        }

        // imagejpeg($temp, $thumbnailPath, 100);
        self::createPath($thumbnailPath,0777);
	    ImageJPEG($temp,$thumbnailPath,100);
	    self::createPath($thumbnailPath,0755);
	    @chmod($path_prefix,0755);

        if (!file_exists($thumbnailPath)){
            $result = "cant create file";
            return $result;
        }

        imagedestroy($temp);
        imagedestroy($thumbnailPic);
        // return $result;
        return $thumbnailPath;
    }
      
      /**
       *  Use on *nix systems.
       *  Used to handle corrupted jpegs, because gd fails to convert them
       *  This function users [convert] (ImageMagick) to change images a bit.
       *  
       *  because a lot of users can upload photos same time -> save temp files 
       * 	using md5() + user_id 
       */
      function makeThumbnailConvert($img,$path,$width, $height,$path_prefix="")
      {
      	//$temp_path =      	
      	// dump($_FILES);
      	if($width!=0)
      	{
      	  $time=strftime("%Y-%m-%d %H:%M:%S",time());
      	  //$tmp_path= $_SERVER['DOCUMENT_ROOT']."/upload/user_photos/".md5($time.$_SESSION['user_id'].$width)."_.jpg";
      	  $dest= $_SERVER['DOCUMENT_ROOT']."/upload/user_photos/".md5($time.$_SESSION['user_id'].$width)."_.jpg";
      	  // $tmp_path= $_SERVER['DOCUMENT_ROOT']."/upload/user_photos/".md5($time.$_SESSION['user_id'].$width)."_.jpg";
      	  $user_photos = $_SERVER['DOCUMENT_ROOT']."/upload/user_photos/";
      	  
      	  passthru("cp $img $user_photos");
      	  // path where file is located.
      	  
      	  $file_name = basename($img);
      	  $tmp_path  = $user_photos.$file_name;
      	  
      	  $cmd= " convert $tmp_path -resize ${width}x$height $dest ";
          passthru($cmd);
      	  //echo "cmd = $cmd <br>";
      	  /*
      	  $tmp_path= "/tmp/".md5($time.$_SESSION['user_id'].$width)."_.jpg";
      	  $dir=$_SERVER['DOCUMENT_ROOT']."/upload/user_photos/";
      	  
      	  // copy file to /user_photos/
      	  $cmd = "cp $tmp_path  $dir";
      	  passthru($cmd);
      	  echo "cmd=[$cmd]<br>";
      	  $file_name = basename($tmp_path);
      	  //$tmp_path = "/tmp/".md5($time.$_SESSION['user_id'].$width)."_.jpg";
          // $cmd="convert $img -resize ${width}x$height $tmp_path";
          //$file_name = basename($img);
          //passthru("cp $img $dir");
          //$cmd =" convert $dir".$file_name." -resize 100x100 $tmp_path ";
          // $cmd =" convert $img -resize 100x100 $tmp_path ";
          $img = $dir.$file_name;
          
          $cmd= " convert $img -resize ${width}x$height $tmp_path ";
          passthru($cmd);
          echo $cmd . "<br>";
          $retval = '';*/
          // system($cmd,$retval);
          // echo "retval=[$retval] <br />";
          self::makeThumbnail($tmp_path,$path,$width,$height,$path_prefix);
      	}
        else 
        	self::makeThumbnail($img,$path,$width,$height,$path_prefix);
        //@unlink($tmp_path);
        // exit;
      }
      
      function LoadJpeg($imgname)
        {
            $im = @imagecreatefromjpeg($imgname); /* Attempt to open */
            if (!$im) { /* See if it failed */
                $im  = imagecreatetruecolor(150, 30); /* Create a black image */
                $bgc = imagecolorallocate($im, 255, 255, 255);
                $tc  = imagecolorallocate($im, 0, 0, 0);
                imagefilledrectangle($im, 0, 0, 150, 30, $bgc);
                /* Output an errmsg */
                imagestring($im, 1, 5, 5, "Error loading $imgname", $tc);
            }
            return $im;
        }
      
      /* 
		 Chmod and create Dirs IF NecessarY
		 @param: $rights - 0777 | 0755
	  */
      function createPath($path,$rights)
      {
            if (strlen($path)<=1)
                    return true;
            $dir = dirname($path);
            // echo "checl: dir  = $dir <br> ";
            if (!file_exists($dir))
            {            	
			   self::createPath($dir,$rights);
               @mkdir($dir,$rights);
               //@mkdir($dir, 0755);
            } 
            else
            {
               //@chmod($dir, 0755);
               @chmod($dir,$rights);
            };
            return true;
      }
      
	  /*
	  	  @input::Remove file by given path.
	  */
	  public function removeFile()
	  {
	  }
  }
?>