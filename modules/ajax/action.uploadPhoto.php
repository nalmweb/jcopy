<?php
 $message = '';
 $images  = '';
 // require_once "./core/JsHttpRequest/JsHttpRequest.php";
 // $JsHttpRequest =& new JsHttpRequest("UTF-8");
 $way = '';
 $imageLink1 = '';
 // dump($_POST);
 $item_id   = isset($_POST['item'])?intval($_POST['item']):0;
 //  $photo_id =0 if it's an upload (not update)
 $photo_id  = isset($_POST['photo'])?intval($_POST['photo']):0;// if an update
 $type 	    = isset($_POST['type'])?intval($_POST['type']):0;
 // upload or an update?
 $bUpload = ( $photo_id ==0 ) ? false:true;
 // А может, тут как раз пригодился бы Factory?
 Socnet_Photo_Config::setTypeId( $type );
 $oPhoto = Socnet_Photo_Config::getObject();
 $images = array(); 
 // dump($oPhoto); 
 //dump($_FILES);
 
 for($i=0;$i<=5;$i++)
 {
	// echo "$i";
 	// GET PATH BY TYPE
 	if(isset($_FILES['photo_'.$i]['tmp_name']))
 	{
 		$image1 = $_FILES['photo_'.$i]['tmp_name'];
 	    // echo " photo ";
 	    if($type = getimagesize($image1))
		{
			//echo "images";
			//$file_way = $_SERVER['DOCUMENT_ROOT']."/upload/attachments/1.jpg";
			list($width, $height, $type, $attr)=getimagesize($image1);
		    // smth like check for valid image.
		    if(empty($width)||empty($type))	
		    				  continue;
		    //$oPhoto->setId(0);
		    $oPhoto->setHeight($height);
		    $oPhoto->setWidth($width);
		    $oPhoto->setAlt("");
		    $oPhoto->setItemId($item_id);
	 		$oPhoto->setDate(date("Y-m-d H:i:s", time()));
		    $photo_id=$oPhoto->save();
		    
		    $oPhoto->setId($photo_id);		    
			// $file = $image1;		    		    
		    $file_way = $oPhoto->savePhotos($image1);
		    
		    $rand = mt_rand(0,2345);
			$file_way .="?$rand";
			$images[]='<img src="'.$file_way.'" border="0">';
			
			/*if ($file_way!='')
			{
					// echo "path = $image1]";
					if(!move_uploaded_file($image1, $file_way)){
						$message .= " <br />Невозможно загрузить картинку.";
					}
					else{
					   $rand = mt_rand(0,2345);
					   $file_way .="?$rand";
					   $images[]='<img src="'.$file_way.'" border="0">';
					   //$way = "http://".BASE_HTTP_HOST."/upload/attachments/1.jpg?$rand";
					   //$imageLink1 = '<img src="'.$way.'" border="0">';
				    }
			}*/
	  } 
	  else $message .= "<br /> файл не является изображением"; 		
 	} 	
 }
  
/*$GLOBALS['_RESULT'] = array (
			"images"   => $images,
			"message"   => $message,	
		        );*/
		        
 $_RESULT  = array (
			"images"   => $images,
			"message"   => $message,	
  );
  
// dump($_RESULT);
// = $_RESULT;
//echo $GLOBALS['_RESULT'];
//echo $_RESULT;
//exit;
//$objResponse = new xajaxResponse();
// photo template
// dump($images);
/*$this->_page->Template->assign('images', $images );
$data = $this->_page->Template->getContents('common/photo/common.photos.list.tpl');
 //dump($data); 
$objResponse->addAlert("asdfaf");
$objResponse->addAppend("photos","innerHTML",$data); 
return $objResponse;
// $this->_page->Template->assign('bodyContent', 'admin/mail/mail.editTemplate.tpl');
// $item = $_POST['item_id'];
// echo "item[$item]";
exit;
*/?>